@extends('layouts.lapor-tuntas')

@section('title', 'Panel Petugas — Lapor Tuntas')
@section('standalone', true)
@section('content')
<div class="staff-layout">
    <aside class="staff-sidebar">
        <a href="{{ route('staff.dashboard') }}" class="brand-lockup"><span class="brand-mark"><span class="material-symbols-outlined" aria-hidden="true">verified</span></span><span class="brand-copy"><strong>Lapor Tuntas</strong><small>Panel Petugas Malang</small></span></a>
        <p class="eyebrow">Menu operasional</p>
        <a class="staff-nav-link active" href="#incoming"><span class="material-symbols-outlined" aria-hidden="true">inbox</span>Antrean laporan</a>
        <a class="staff-nav-link" href="#incoming"><span class="material-symbols-outlined" aria-hidden="true">fact_check</span>Verifikasi lapangan</a>
        @if($staffRole === 'admin')<a class="staff-nav-link" href="#incoming"><span class="material-symbols-outlined" aria-hidden="true">forward_to_inbox</span>Disposisi OPD</a>@endif
        <a class="staff-nav-link" href="#staff-map"><span class="material-symbols-outlined" aria-hidden="true">map</span>Pemantauan wilayah</a>
        <div class="staff-sidebar-bottom"><span class="status-badge status-Diproses">Sistem demo aktif</span><p>Pemerintah Kota Malang<br>Pusat Tindak Cepat</p><span class="text-xs text-white/60">Sesi: {{ $staffRole === 'admin' ? 'Admin demo' : 'Petugas demo' }}</span></div>
    </aside>
    <main class="staff-main">
        <header class="staff-toolbar"><div><span class="eyebrow">Kota Malang · data simulasi</span><h1 class="page-title" style="font-size:26px">Antrean laporan masuk</h1></div><form method="POST" action="{{ route('staff.logout') }}">@csrf<button class="button button-secondary" type="submit"><span class="material-symbols-outlined" aria-hidden="true">logout</span>Keluar</button></form></header>
        @if(session('status'))<p class="demo-banner" role="status">{{ session('status') }}</p>@endif
        <div class="demo-banner">Dashboard simulasi. Perubahan status, catatan, dan penugasan hanya tersimpan pada sesi demo ini.</div>
        <div class="staff-grid">
            <article class="metric-card"><small>Total laporan demo</small><strong>{{ count($reports) }}</strong></article>
            <article class="metric-card"><small>Baru</small><strong>{{ collect($reports)->where('status', 'Baru')->count() }}</strong></article>
            <article class="metric-card"><small>Sedang ditangani</small><strong>{{ collect($reports)->whereIn('status', ['Ditugaskan', 'Diproses'])->count() }}</strong></article>
            <article class="metric-card"><small>Selesai</small><strong>{{ collect($reports)->where('status', 'Selesai')->count() }}</strong></article>
        </div>
        <div class="staff-content" id="incoming">
            <section class="staff-list">
                <div class="staff-list-head"><div><h2 class="m-0 text-lg">Laporan masuk</h2><p class="m-0 text-xs text-secondary">Kelola status dan tindak lanjut</p></div><label class="sr-only" for="staff-filter">Filter laporan</label><select id="staff-filter" class="field-control" style="width:auto;min-height:40px" data-staff-filter><option value="all">Semua status</option><option>Baru</option><option>Ditugaskan</option><option>Diproses</option><option>Selesai</option><option>Ditolak</option></select></div>
                @foreach($reports as $report)
                    <article class="staff-row" data-staff-row data-status="{{ $report['status'] }}">
                        <div><div class="flex flex-wrap items-center gap-2"><h3>{{ $report['title'] }}</h3><x-status-badge :status="$report['status']" /></div><p>{{ $report['category'] }} · {{ $report['location'] }} · {{ $report['reported_ago'] }}</p><code class="font-mono text-xs">{{ $report['ticket_id'] }}</code><p class="mb-0">Instansi: {{ $report['agency'] }}</p><a class="text-xs font-bold text-primary" href="{{ route('reports.show', $report['ticket_id']) }}">Lihat detail publik →</a></div>
                        <form method="POST" action="{{ route('staff.reports.update', $report['ticket_id']) }}">
                            @csrf @method('PATCH')
                            <label class="sr-only" for="status-{{ $report['ticket_id'] }}">Ubah status tiket {{ $report['ticket_id'] }}</label>
                            <select class="field-control" id="status-{{ $report['ticket_id'] }}" name="status">
                                @foreach(['Baru', 'Ditugaskan', 'Diproses', 'Selesai', 'Ditolak'] as $status)<option @selected($report['status'] === $status)>{{ $status }}</option>@endforeach
                            </select>
                            @if($staffRole === 'admin')<label class="sr-only" for="agency-{{ $report['ticket_id'] }}">Instansi penanganan</label><select class="field-control" id="agency-{{ $report['ticket_id'] }}" name="agency"><option value="">{{ $report['agency'] }}</option>@foreach($categories as $category)<option value="{{ $category['agency'] }}">{{ $category['agency'] }}</option>@endforeach</select>@endif
                            <label class="sr-only" for="note-{{ $report['ticket_id'] }}">Catatan petugas atau alasan penolakan</label><input class="field-control" id="note-{{ $report['ticket_id'] }}" name="note" placeholder="Catatan / alasan penolakan">
                            <button class="button button-primary" type="submit"><span class="material-symbols-outlined" aria-hidden="true">save</span>Simpan perubahan demo</button>
                        </form>
                    </article>
                @endforeach
            </section>
            <aside class="staff-map-card" id="staff-map"><h2 class="m-0 text-base">Pantauan wilayah</h2><p class="form-help">Peta ilustratif · {{ count($reports) }} tiket sampel</p><x-civic-map :mini="true" /><div class="similar-reports"><strong class="text-sm">Status marker</strong><p class="m-0 mt-1 text-xs text-secondary">Baru · Ditugaskan · Diproses · Selesai · Ditolak</p></div></aside>
        </div>
    </main>
</div>
@endsection
