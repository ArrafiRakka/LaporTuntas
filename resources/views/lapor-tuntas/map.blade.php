@extends('layouts.lapor-tuntas')

@section('title', 'Peta Laporan — Lapor Tuntas')
@section('body-class', 'map-page')
@section('content')
<main data-map-geolocation-gate>
    <div class="map-layout">
        @php($selectedTicket = $reports[0]['ticket_id'] ?? null)
        <x-civic-map :reports="$reports" :selected="$selectedTicket" />
        <a href="{{ route('reports.create') }}" class="button button-brand map-floating-action"><span class="material-symbols-outlined" aria-hidden="true">add</span>Buat laporan</a>
        <aside class="report-panel" aria-label="Daftar laporan sekitar">
            <div class="report-panel-head">
                <span class="bottom-sheet-handle" aria-hidden="true"></span>
                <div class="flex items-start justify-between gap-3">
                    <div><h1>Laporan di sekitarmu</h1><p>Menampilkan <span data-report-count>{{ count($reports) }}</span> laporan aktif dalam radius <span data-radius-label>{{ $radius }}</span> di Kota Malang</p></div>
                    <span class="material-symbols-outlined text-secondary" title="Data simulasi" aria-label="Data simulasi">info</span>
                </div>
                <div class="filter-row" aria-label="Filter kategori">
                    <button type="button" class="filter-chip" data-filter-category="all" aria-pressed="true">Semua</button>
                    @foreach(config('lapor_tuntas.categories') as $key => $category)
                        <button type="button" class="filter-chip" data-filter-category="{{ $key }}" aria-pressed="false">{{ $category['label'] }}</button>
                    @endforeach
                </div>
                <div class="flex items-center justify-between gap-2">
                    <div class="filter-row mt-2" aria-label="Filter status">
                        <button type="button" class="filter-chip" data-filter-status="all" aria-pressed="true">Semua status</button>
                        <button type="button" class="filter-chip" data-filter-status="Baru" aria-pressed="false">Baru</button>
                        <button type="button" class="filter-chip" data-filter-status="Diproses" aria-pressed="false">Diproses</button>
                    </div>
                    <label class="sr-only" for="radius-filter">Radius pencarian</label>
                    <select id="radius-filter" class="filter-radius" data-radius-filter>
                        @foreach(['500 m', '1 km', '5 km'] as $option)
                            <option @selected($radius === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="report-list" data-report-list>
                @forelse($reports as $report)
                    <x-report-card :report="$report" :selected="$loop->first" />
                @empty
                    <div class="no-reports"><span class="material-symbols-outlined" aria-hidden="true">near_me</span><p>Belum ada laporan aktif di sekitar.</p><a class="button button-primary" href="{{ route('reports.create') }}">Buat laporan pertama</a></div>
                @endforelse
            </div>
            <div class="px-5 py-3 border-t border-divider text-xs text-secondary">Kanal Pengaduan Resmi Pemkot Malang · <strong>Data simulasi</strong></div>
        </aside>
    </div>
    <nav class="main-mobile-nav" aria-label="Akses cepat"><a class="active" href="{{ route('reports.map') }}"><span class="material-symbols-outlined" aria-hidden="true">map</span>Peta</a><a href="{{ route('tickets.track') }}"><span class="material-symbols-outlined" aria-hidden="true">search</span>Lacak tiket</a><a href="{{ route('reports.create') }}"><span class="material-symbols-outlined" aria-hidden="true">add_circle</span>Buat laporan</a></nav>
</main>
@endsection
