@extends('layouts.lapor-tuntas')

@section('title', 'Lokasi Belum Aktif — Lapor Tuntas')
@section('standalone', true)
@section('content')
<div class="location-page">
    <a href="{{ route('welcome') }}" class="brand-lockup" aria-label="Lapor Tuntas, Kota Malang">
        <span class="brand-mark"><span class="material-symbols-outlined" aria-hidden="true">location_on</span></span>
        <span class="brand-copy"><strong>Lapor Tuntas</strong><small>Kota Malang</small></span>
    </a>
    <main class="location-main" style="padding-block:28px">
        <svg class="location-illustration" viewBox="0 0 80 80" fill="none" aria-hidden="true">
            <ellipse cx="40" cy="56" rx="26" ry="9" stroke="#d7e1e5" stroke-width="1.5" stroke-dasharray="4 3"/><path d="M40 54S26 41.5 26 27a14 14 0 1 1 28 0C54 41.5 40 54 40 54Z" stroke="#617482" stroke-width="2" fill="white"/><path d="M40 22v6m0 5.5v.1" stroke="#617482" stroke-width="2.5" stroke-linecap="round"/><path d="m20 60 40-40" stroke="#17324d" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <h1>Lokasi belum aktif</h1>
        <p>Aplikasi membutuhkan izin lokasi untuk menampilkan peta laporan di Kota Malang.</p>
        <ol class="location-steps">
            <li><span>1</span><span>Ketuk ikon gembok atau info di bilah alamat browser</span></li>
            <li><span>2</span><span>Ubah izin <strong>Lokasi</strong> menjadi <strong>Izinkan</strong></span></li>
            <li><span>3</span><span>Kembali ke halaman ini dan tekan <strong>Coba lagi</strong></span></li>
        </ol>
        <button type="button" class="button button-brand button-full" data-request-location>Coba lagi</button>
        <p class="field-error" role="status" data-location-message hidden></p>
        <a href="{{ route('tickets.track') }}" class="inline-flex items-center gap-1 mt-4 font-bold text-secondary">Lacak tiket dengan ID <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
    </main>
    <footer class="location-footer"><span>Kanal Publik Warga Malang</span><span class="font-mono">v1.0 · Demo</span></footer>
</div>
@endsection
