@extends('layouts.lapor-tuntas')

@section('title', 'Buat Laporan — Lapor Tuntas')
@section('content')
<main class="form-shell">
    <a href="{{ route('reports.map') }}" class="inline-flex items-center gap-1 text-sm font-bold text-secondary"><span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>Kembali ke peta</a>
    <div class="mt-4"><span class="eyebrow">Kanal Publik Warga Malang</span><h1 class="page-title" style="font-size:30px">Buat laporan</h1><p class="page-subtitle">Ceritakan masalah fasilitas publik agar bisa ditindaklanjuti.</p></div>
    @if($errors->any())
        <div class="error-summary" role="alert"><strong>Periksa kembali laporanmu.</strong><ul class="mt-1 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" data-report-form>
        @csrf
        <section class="form-section">
            <h2>Foto bukti</h2><p class="form-help">Tambahkan 1 sampai 5 foto agar petugas memahami kondisi di lapangan. Maksimal 5 MB per foto.</p>
            <label class="upload-drop" for="report-photos"><span><span class="material-symbols-outlined" aria-hidden="true">add_a_photo</span><strong class="block text-navy">Ambil atau unggah foto</strong><span class="text-sm">JPG, PNG, atau WebP</span></span></label>
            <input id="report-photos" name="photos[]" type="file" accept="image/jpeg,image/png,image/webp" multiple required class="sr-only" data-photo-input>
            <div class="upload-previews" data-photo-previews aria-live="polite"></div>
            @error('photos')<p class="field-error">{{ $message }}</p>@enderror
            @error('photos.*')<p class="field-error">{{ $message }}</p>@enderror
        </section>
        <section class="form-section">
            <label class="field-label" for="report-category">Kategori</label>
            <select class="field-control" id="report-category" name="category" required>
                <option value="">Pilih kategori masalah</option>
                @foreach($categories as $key => $category)<option value="{{ $key }}" @selected(old('category') === $key)>{{ $category['label'] }}</option>@endforeach
            </select>
            @error('category')<p class="field-error">{{ $message }}</p>@enderror
        </section>
        <section class="form-section">
            <label class="field-label" for="report-location">Lokasi masalah</label>
            <p class="form-help">Izin lokasi dibutuhkan untuk mengisi titik masalah. Koordinat yang dikirim hanya dipakai sebagai lokasi laporan.</p>
            <div class="mini-map mb-3"><svg viewBox="0 0 1000 720" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="1000" height="720" fill="#eaf1e8"/><path d="M100-20 180 760M-20 390 910 185M270-40 450 760M-40 110 850 138" fill="none" stroke="#fff" stroke-width="28"/></svg><span class="mini-map-pin material-symbols-outlined" aria-hidden="true">location_on</span></div>
            <input class="field-control" id="report-location" name="location_label" placeholder="Contoh: Jl. Veteran, dekat Gerbang FIA UB" value="{{ old('location_label') }}" required maxlength="180">
            <input type="hidden" name="latitude" value="{{ old('latitude') }}" data-latitude>
            <input type="hidden" name="longitude" value="{{ old('longitude') }}" data-longitude>
            <p class="form-help mt-2" data-gps-state role="status">Memeriksa izin lokasi perangkat…</p><a class="field-error font-bold" data-location-help href="{{ route('location.denied') }}" hidden>Lihat cara mengaktifkan lokasi</a>
            @error('location_label')<p class="field-error">{{ $message }}</p>@enderror
        </section>
        <section class="form-section">
            <label class="field-label" for="report-description">Ceritakan masalahnya</label>
            <p class="form-help">Jelaskan kondisi dan patokan terdekat. Hindari menyertakan data pribadi.</p>
            <textarea class="field-control" id="report-description" name="description" required minlength="12" maxlength="500" placeholder="Contoh: Ada lubang cukup dalam di sisi kiri jalan…">{{ old('description') }}</textarea>
            <div class="flex justify-between text-xs text-secondary mt-1"><span>@error('description')<span class="text-red-700">{{ $message }}</span>@enderror</span><span data-character-count>0 / 500</span></div>
        </section>
        <div class="similar-reports"><h3>Laporan serupa di sekitarmu</h3><div class="similar-report"><span>Lubang jalan aspal cukup dalam (~15cm)</span><x-status-badge status="Diproses" /></div><p class="m-0 text-xs text-secondary">Contoh dari data simulasi. Periksa laporan ini sebelum mengirim laporan baru.</p></div>
        <div class="form-actions"><button class="button button-primary button-full" type="submit" data-submit-report disabled><span class="material-symbols-outlined" aria-hidden="true">send</span>Kirim laporan</button><p class="m-0 text-center text-xs text-secondary">Laporan demo disimpan sementara di sesi browser ini; foto tidak disimpan.</p></div>
    </form>
</main>
@endsection
