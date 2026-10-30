@extends('layouts.lapor-tuntas')

@section('title', 'Izin Lokasi — Lapor Tuntas')
@section('standalone', true)
@section('content')
<div class="location-page">
    <a href="{{ route('welcome') }}" class="brand-lockup" aria-label="Lapor Tuntas, Kota Malang">
        <span class="brand-mark"><span class="material-symbols-outlined" aria-hidden="true">location_on</span></span>
        <span class="brand-copy"><strong>Lapor Tuntas</strong><small>Kota Malang</small></span>
    </a>
    <main class="location-main">
        <svg class="location-illustration" viewBox="0 0 80 80" fill="none" aria-hidden="true">
            <circle cx="40" cy="56" r="18" stroke="#d7e1e5" stroke-width="1.75" stroke-dasharray="3 3"/><ellipse cx="40" cy="56" rx="28" ry="10" stroke="#d7e1e5" stroke-width="1.5" stroke-dasharray="4 3"/>
            <circle cx="40" cy="56" r="3" fill="#16a6d8"/><path d="M40 54S26 41.5 26 27a14 14 0 1 1 28 0C54 41.5 40 54 40 54Z" stroke="#17324d" stroke-width="2" fill="white"/><circle cx="40" cy="27" r="4.5" fill="#16a6d8"/>
        </svg>
        <h1>Aktifkan lokasi untuk melihat laporan di sekitarmu</h1>
        <p>Kami memakai lokasi hanya untuk membuka peta dan mengisi titik masalah. Koordinat perangkatmu tidak disimpan.</p>
        <div class="demo-banner" style="margin-bottom:16px">Peta saat ini menampilkan data simulasi wilayah Kota Malang.</div>
        <button class="button button-brand button-full" type="button" data-request-location>Aktifkan lokasi</button>
        <p class="field-error" role="status" data-location-message hidden></p>
        <a href="{{ route('tickets.track') }}" class="inline-flex items-center gap-1 mt-4 font-bold text-secondary">Lacak tiket dengan ID <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
    </main>
    <footer class="location-footer"><span>Kanal Publik Warga Malang</span><span class="font-mono">v1.0 · Demo</span></footer>
</div>
@endsection
