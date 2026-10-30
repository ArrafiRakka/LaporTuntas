@extends('layouts.lapor-tuntas')

@section('title', 'Laporan Terkirim — Lapor Tuntas')
@section('content')
<main class="receipt-shell">
    <div class="receipt-success"><span class="success-mark"><span class="material-symbols-outlined" aria-hidden="true">check</span></span><div><span class="eyebrow">Laporan berhasil dikirim</span><h1 class="page-title" style="font-size:26px">Simpan ID tiketmu</h1><p class="page-subtitle">Gunakan ID ini untuk melacak laporan. Tanpa ID, laporan mungkin sulit ditemukan.</p></div></div>
    <div class="ticket-id"><div><small class="block mb-1 text-secondary">ID Tiket Pelaporan</small><code>{{ $report['ticket_id'] }}</code></div><button type="button" class="button button-secondary" data-copy="{{ $report['ticket_id'] }}"><span class="material-symbols-outlined" aria-hidden="true">content_copy</span><span data-copy-label>Salin ID</span></button></div>
    <div class="receipt-summary">
        <div><small>Kategori</small><strong>{{ $report['category'] }}</strong></div><div><small>Lokasi</small><strong>{{ $report['location'] }}</strong></div>
        <div><small>Waktu</small><strong>{{ $report['reported_at'] }}</strong></div><div><small>Status awal</small><x-status-badge :status="$report['status']" /></div>
    </div>
    <div class="receipt-bottom"><img class="qr-image" src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&amp;margin=8&amp;data={{ urlencode(route('reports.show', $report['ticket_id'])) }}" alt="QR untuk membuka detail laporan {{ $report['ticket_id'] }}" loading="lazy"><div><strong>Simpan bukti tiket</strong><p class="form-help">Pindai QR untuk membuka detail. QR mengarah ke tautan publik dengan informasi laporan yang aman ditampilkan.</p><span class="demo-banner">Data simulasi · laporan tersimpan di sesi ini</span></div></div>
    <div class="receipt-actions grid gap-3 mt-6 sm:grid-cols-2"><button type="button" class="button button-secondary" data-print-ticket><span class="material-symbols-outlined" aria-hidden="true">download</span>Simpan tiket (PDF)</button><a href="{{ route('reports.show', $report['ticket_id']) }}" class="button button-primary"><span class="material-symbols-outlined" aria-hidden="true">track_changes</span>Lacak laporan</a></div>
    <p class="print-only mt-4 text-sm text-secondary">Lapor Tuntas · Kanal demo Kota Malang</p>
</main>
@endsection
