@extends('layouts.lapor-tuntas')

@section('title', 'Masuk Petugas — Lapor Tuntas')
@section('content')
<main class="login-shell">
    <a href="{{ route('reports.map') }}" class="inline-flex items-center gap-1 text-sm font-bold text-secondary"><span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>Kembali ke peta</a>
    <div class="mt-5"><span class="brand-mark"><span class="material-symbols-outlined" aria-hidden="true">verified_user</span></span><span class="eyebrow block mt-4">Ruang kerja layanan publik</span><h1 class="page-title" style="font-size:28px">Masuk petugas & admin</h1><p class="page-subtitle">Akses dashboard untuk memproses laporan warga.</p></div>
    @if($errors->any())<div class="error-summary" role="alert">{{ $errors->first() }}</div>@endif
    <div class="demo-banner mt-5">Mode demonstrasi — akun, status, dan penugasan belum terhubung ke backend produksi.</div>
    <form method="POST" action="{{ route('staff.authenticate') }}" class="login-choice">
        @csrf
        <button class="button button-primary button-full" type="submit" name="role" value="petugas"><span class="material-symbols-outlined" aria-hidden="true">engineering</span>Masuk sebagai Petugas Demo</button>
        <button class="button button-secondary button-full" type="submit" name="role" value="admin"><span class="material-symbols-outlined" aria-hidden="true">admin_panel_settings</span>Masuk sebagai Admin Demo</button>
    </form>
    <p class="form-help mt-4">Pilihan ini hanya membuka dashboard simulasi pada sesi browser ini. Gunakan kredensial resmi setelah backend autentikasi disiapkan.</p>
</main>
@endsection
