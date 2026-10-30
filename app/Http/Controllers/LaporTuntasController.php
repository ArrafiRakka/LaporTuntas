<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LaporTuntasController extends Controller
{
    public function welcome(): View
    {
        return view('lapor-tuntas.location');
    }

    public function locationDenied(): View
    {
        return view('lapor-tuntas.location-denied');
    }

    public function map(Request $request): View
    {
        $reports = $this->reports();
        $activeReports = array_values(array_filter($reports, fn (array $report): bool => ! in_array($report['status'], ['Selesai', 'Ditolak'], true)));

        return view('lapor-tuntas.map', [
            'reports' => $activeReports,
            'radius' => $request->query('radius', '1 km'),
            'isDemo' => true,
        ]);
    }

    public function createReport(): View
    {
        return view('lapor-tuntas.report-form', [
            'categories' => config('lapor_tuntas.categories'),
        ]);
    }

    public function storeReport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:'.implode(',', array_keys(config('lapor_tuntas.categories')))],
            'description' => ['required', 'string', 'min:12', 'max:500'],
            'location_label' => ['required', 'string', 'max:180'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'photos' => ['required', 'array', 'min:1', 'max:5'],
            'photos.*' => ['image', 'max:5120'],
        ], [
            'photos.*.image' => 'Gunakan foto berformat JPG, PNG, atau WebP.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
        ]);

        do {
            $ticketId = 'LT-'.Str::upper(Str::random(4)).'-'.Str::upper(Str::random(4));
        } while (array_key_exists($ticketId, $this->reports()));
        $photoNames = collect($request->file('photos', []))
            ->map(fn ($photo): string => $photo->getClientOriginalName())
            ->all();

        $report = [
            'ticket_id' => $ticketId,
            'title' => Str::limit($validated['description'], 58, '…'),
            'category' => config('lapor_tuntas.categories')[$validated['category']]['label'],
            'category_key' => $validated['category'],
            'description' => $validated['description'],
            'location' => $validated['location_label'],
            'latitude' => (float) $validated['latitude'],
            'longitude' => (float) $validated['longitude'],
            'status' => 'Baru',
            'reported_at' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i').' WIB',
            'reported_ago' => 'Baru saja',
            'agency' => config('lapor_tuntas.categories')[$validated['category']]['agency'],
            'photos' => $photoNames,
            'timeline' => [[
                'status' => 'Baru',
                'description' => 'Laporan berhasil dikirim dan menunggu penugasan.',
                'time' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i').' WIB',
            ]],
            'map' => ['top' => '48%', 'left' => '52%'],
            'is_demo' => true,
        ];

        $demoReports = session('demo_reports', []);
        $demoReports[$ticketId] = $report;
        session(['demo_reports' => $demoReports]);

        return redirect()->route('reports.receipt', ['ticketId' => $ticketId]);
    }

    public function receipt(string $ticketId): View
    {
        $report = $this->findReport($ticketId);
        abort_if($report === null, 404);

        return view('lapor-tuntas.receipt', compact('report'));
    }

    public function track(Request $request): View
    {
        $ticketId = Str::upper(trim((string) $request->query('ticket_id', '')));
        $report = $ticketId === '' ? null : $this->findReport($ticketId);

        return view('lapor-tuntas.track', [
            'ticketId' => $ticketId,
            'report' => $report,
            'notFound' => $ticketId !== '' && $report === null,
        ]);
    }

    public function lookup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ticket_id' => ['required', 'string', 'max:32'],
        ], ['ticket_id.required' => 'Masukkan ID tiket untuk mencari laporan.']);

        return redirect()->route('tickets.track', ['ticket_id' => Str::upper(trim($validated['ticket_id']))]);
    }

    public function reportDetail(string $ticketId): View
    {
        $report = $this->findReport($ticketId);
        abort_if($report === null, 404);

        return view('lapor-tuntas.report-detail', compact('report'));
    }

    public function staffLogin(): View
    {
        return view('lapor-tuntas.staff-login');
    }

    public function authenticateStaff(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:petugas,admin'],
        ]);

        $request->session()->regenerate();
        $request->session()->put('demo_staff_role', $validated['role']);

        return redirect()->route('staff.dashboard');
    }

    public function staffDashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('demo_staff_role')) {
            return redirect()->route('staff.login');
        }

        return view('lapor-tuntas.staff-dashboard', [
            'reports' => $this->reports(),
            'staffRole' => $request->session()->get('demo_staff_role'),
            'categories' => config('lapor_tuntas.categories'),
        ]);
    }

    public function updateReportStatus(Request $request, string $ticketId): RedirectResponse
    {
        if (! $request->session()->has('demo_staff_role')) {
            return redirect()->route('staff.login');
        }

        abort_if($this->findReport($ticketId) === null, 404);
        $validated = $request->validate([
            'status' => ['required', 'in:Baru,Ditugaskan,Diproses,Selesai,Ditolak'],
            'note' => ['required_if:status,Ditolak', 'nullable', 'string', 'max:240'],
            'agency' => [
                'nullable',
                'string',
                Rule::in(array_values(array_unique(array_column(config('lapor_tuntas.categories'), 'agency')))),
            ],
        ]);

        $currentReport = $this->findReport($ticketId);
        abort_if($validated['status'] === 'Ditolak' && $request->session()->get('demo_staff_role') !== 'admin', 403);
        abort_if(! empty($validated['agency']) && $request->session()->get('demo_staff_role') !== 'admin', 403);
        $timeline = $currentReport['timeline'] ?? [];
        $timeline[] = [
            'status' => $validated['status'],
            'description' => 'Status diperbarui oleh petugas (simulasi).',
            'time' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i').' WIB',
        ];

        $statuses = session('demo_statuses', []);
        $statuses[$ticketId] = [
            'status' => $validated['status'],
            'note' => $validated['note'] ?? '',
            'agency' => $validated['agency'] ?: ($currentReport['agency'] ?? ''),
            'rejection_reason' => $validated['status'] === 'Ditolak'
                ? $validated['note']
                : ($currentReport['rejection_reason'] ?? null),
            'timeline' => $timeline,
            'updated_at' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i').' WIB',
        ];
        session(['demo_statuses' => $statuses]);

        return back()->with('status', 'Perubahan tersimpan untuk sesi demo ini.');
    }

    public function logoutStaff(Request $request): RedirectResponse
    {
        $request->session()->forget('demo_staff_role');
        $request->session()->regenerateToken();

        return redirect()->route('staff.login');
    }

    /** @return array<string, array<string, mixed>> */
    private function reports(): array
    {
        $reports = config('lapor_tuntas.reports');

        foreach (session('demo_reports', []) as $ticketId => $report) {
            $reports[$ticketId] = $report;
        }

        foreach (session('demo_statuses', []) as $ticketId => $updates) {
            if (isset($reports[$ticketId])) {
                $reports[$ticketId] = array_merge($reports[$ticketId], $updates);
            }
        }

        return $reports;
    }

    /** @return array<string, mixed>|null */
    private function findReport(string $ticketId): ?array
    {
        return $this->reports()[Str::upper($ticketId)] ?? null;
    }
}
