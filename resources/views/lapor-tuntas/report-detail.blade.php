@extends('layouts.lapor-tuntas')

@section('title', 'Detail Laporan '.$report['ticket_id'].' — Lapor Tuntas')
@section('content')
<main class="page-wrap">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5"><a href="{{ route('reports.map') }}" class="inline-flex items-center gap-1 text-sm font-bold text-secondary"><span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>Kembali ke peta</a><span class="demo-banner">Informasi publik · data simulasi</span></div>
    <div class="detail-layout">
        <article class="detail-card">
            @if(!empty($report['image']))<img class="detail-photo" src="{{ $report['image'] }}" alt="Foto masalah {{ $report['category'] }} di {{ $report['location'] }}" loading="lazy">
            @elseif(!empty($report['photos']))<div class="detail-photo-placeholder"><div><span class="material-symbols-outlined text-4xl" aria-hidden="true">photo_camera</span><p>Nama foto terlampir pada sesi demo:</p><strong>{{ implode(', ', $report['photos']) }}</strong></div></div>
            @else<div class="detail-photo-placeholder"><div><span class="material-symbols-outlined text-4xl" aria-hidden="true">{{ config('lapor_tuntas.categories.'.$report['category_key'].'.icon', 'location_on') }}</span><p>Foto contoh tidak tersedia untuk laporan ini.</p></div></div>@endif
            <div class="detail-content">
                <div class="flex flex-wrap items-center justify-between gap-3"><span class="eyebrow">{{ $report['category'] }} · {{ $report['agency'] }}</span><x-status-badge :status="$report['status']" /></div>
                <h1>{{ $report['title'] }}</h1><p class="detail-meta">{{ $report['description'] }}</p>
                <div class="ticket-id"><div><small class="block mb-1 text-secondary">ID Tiket</small><code>{{ $report['ticket_id'] }}</code></div><button type="button" class="button button-secondary" data-copy="{{ $report['ticket_id'] }}"><span class="material-symbols-outlined" aria-hidden="true">content_copy</span>Salin</button></div>
                <div class="detail-facts">
                    <div><small>Kategori</small><strong>{{ $report['category'] }}</strong></div><div><small>Lokasi masalah</small><strong>{{ $report['location'] }}, Kota Malang</strong></div>
                    <div><small>Dilaporkan</small><strong>{{ $report['reported_at'] }}</strong></div><div><small>Instansi penanganan</small><strong>{{ $report['agency'] }}</strong></div>
                </div>
                @if($report['status'] === 'Ditolak' && !empty($report['rejection_reason']))<p class="track-error"><strong>Alasan laporan ditolak:</strong> {{ $report['rejection_reason'] }}</p>@endif
            </div>
        </article>
        <aside class="grid gap-4">
            <section class="detail-card p-5"><h2 class="m-0 text-lg">Linimasa laporan</h2><p class="form-help">Catatan publik atas perubahan status.</p><div class="timeline">
                @foreach($report['timeline'] ?? [] as $item)<div class="timeline-item"><strong>{{ $item['status'] }}</strong><p>{{ $item['description'] }}</p><time>{{ $item['time'] }}</time></div>@endforeach
            </div></section>
            <section class="detail-card p-5"><h2 class="m-0 text-lg">Lokasi masalah</h2><p class="form-help">Titik laporan di Kota Malang. Koordinat perangkat pelapor tidak ditampilkan.</p><x-civic-map :mini="true" /></section>
        </aside>
    </div>
</main>
@endsection
