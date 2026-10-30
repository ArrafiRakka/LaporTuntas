@extends('layouts.lapor-tuntas')

@section('title', 'Lacak Tiket — Lapor Tuntas')
@section('content')
<main class="track-shell">
    <a href="{{ route('reports.map') }}" class="inline-flex items-center gap-1 text-sm font-bold text-secondary"><span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>Kembali ke peta</a>
    <div class="mt-5"><span class="eyebrow">Pelacakan tindak lanjut</span><h1 class="page-title">Lacak tiket</h1><p class="page-subtitle">Pantau status penanganan laporan sarana publik Kota Malang.</p></div>
    @if($errors->any())<div class="track-error" role="alert">{{ $errors->first('ticket_id') }}</div>@endif
    @if($notFound)<div class="track-error" role="alert"><strong>ID tiket belum ditemukan.</strong> Periksa kembali ID yang kamu masukkan. Contoh format: LT-8F3K-92QX.</div>@endif
    <form method="POST" action="{{ route('tickets.lookup') }}" class="mt-5">
        @csrf
        <label class="field-label" for="ticket-id">ID tiket</label>
        <div class="track-input-row"><input class="field-control font-mono" id="ticket-id" name="ticket_id" value="{{ $ticketId }}" placeholder="Contoh: LT-8F3K-92QX" required maxlength="32" autocomplete="off"><button class="button button-primary" type="submit"><span class="material-symbols-outlined" aria-hidden="true">search</span>Cari laporan</button></div>
    </form>
    <p class="form-help mt-3">ID tiket tercantum pada konfirmasi laporan atau tiket yang kamu simpan.</p>
    @if($report)
        <article class="track-result">
            <div><x-status-badge :status="$report['status']" /><h2 class="mt-2 mb-1 text-base">{{ $report['title'] }}</h2><p class="m-0 text-sm text-secondary">{{ $report['location'] }} · {{ $report['reported_ago'] }}</p><code class="font-mono text-xs">{{ $report['ticket_id'] }}</code></div>
            <a class="button button-secondary" href="{{ route('reports.show', $report['ticket_id']) }}">Lihat detail</a>
        </article>
        <p class="demo-banner mt-4">Hasil pencarian berasal dari data simulasi atau laporan sementara pada sesi demo ini.</p>
    @else
        <div class="similar-reports mt-6"><h3>Butuh bantuan mencari nomor tiket?</h3><p class="m-0 text-sm text-secondary">Periksa huruf dan angka pada tiketmu. ID tiket hanya digunakan untuk melihat informasi laporan publik.</p></div>
    @endif
</main>
@endsection
