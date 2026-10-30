@props(['reports' => [], 'selected' => null, 'mini' => false])
<div class="{{ $mini ? 'mini-map' : 'map-canvas' }}" @if(!$mini) data-civic-map @endif>
    <svg class="{{ $mini ? '' : 'map-drawing' }}" viewBox="0 0 1000 720" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <defs><pattern id="civic-grid-{{ $mini ? 'mini' : 'main' }}" width="48" height="48" patternUnits="userSpaceOnUse"><path d="M48 0H0V48" fill="none" stroke="#dce7da" stroke-width="1"/></pattern></defs>
        <rect width="1000" height="720" fill="#eaf1e8"/><rect width="1000" height="720" fill="url(#civic-grid-{{ $mini ? 'mini' : 'main' }} )" opacity=".6"/>
        <path d="M-30 170C140 190 280 160 430 220S760 330 1030 265" fill="none" stroke="#d1e4ff" stroke-width="19" stroke-linecap="round"/>
        <g fill="none" stroke-linecap="round">
            <path d="M100-20 180 760M-20 390 910 185M270-40 450 760M420 80 930 570M-40 110 850 138M180 560 790 675" stroke="#d7e1e5" stroke-width="27" opacity=".65"/>
            <path d="M100-20 180 760M-20 390 910 185M270-40 450 760M420 80 930 570M-40 110 850 138M180 560 790 675" stroke="#fff" stroke-width="20"/>
        </g>
        @unless($mini)
            <span class="map-street" style="top:12%;left:7%;transform:rotate(7deg)">Jl. Soekarno-Hatta</span>
            <span class="map-label" style="top:47%;left:25%;transform:rotate(-12deg)">Jl. Veteran</span>
            <span class="map-street" style="top:28%;left:43%;transform:rotate(65deg)">Jl. MT Haryono</span>
            <span class="map-street" style="top:18%;left:68%">Jl. Bandung</span>
            <span class="map-street" style="bottom:24%;left:34%;transform:rotate(-6deg)">Jl. Semeru</span>
            <span class="map-label" style="bottom:13%;left:53%">Jl. Besar Ijen</span>
            <span class="map-user" title="Area sekitar lokasimu" aria-label="Area sekitar lokasimu"></span>
        @endunless
    </svg>
    @if(!$mini)
        @foreach($reports as $report)
            <button type="button" class="map-marker status-{{ str_replace(' ', '-', $report['status']) }}" style="top:{{ $report['map']['top'] ?? '50%' }};left:{{ $report['map']['left'] ?? '50%' }}" data-map-marker data-ticket="{{ $report['ticket_id'] }}" data-category="{{ $report['category_key'] }}" data-category-label="{{ $report['category'] }}" data-title="{{ $report['title'] }}" data-location="{{ $report['location'] }}" data-status="{{ $report['status'] }}" data-distance="{{ $report['distance_km'] ?? 1 }}" data-image="{{ $report['image'] ?? '' }}" data-detail-url="{{ route('reports.show', $report['ticket_id']) }}" aria-label="{{ $report['category'] }} — {{ $report['title'] }}" aria-pressed="{{ $selected === $report['ticket_id'] ? 'true' : 'false' }}">
                <span class="material-symbols-outlined" aria-hidden="true">{{ config('lapor_tuntas.categories.'.$report['category_key'].'.icon', 'location_on') }}</span>
            </button>
        @endforeach
        <div class="map-popup" data-map-popup>
            @php($firstReport = collect($reports)->firstWhere('ticket_id', $selected) ?? collect($reports)->first())
            @if($firstReport)
                @if(!empty($firstReport['image']))
                    <img src="{{ $firstReport['image'] }}" alt="Foto laporan {{ $firstReport['category'] }}" loading="lazy">
                @else
                    <div class="detail-photo-placeholder" style="height:80px;border-radius:9px"><span class="material-symbols-outlined" aria-hidden="true">{{ config('lapor_tuntas.categories.'.$firstReport['category_key'].'.icon', 'location_on') }}</span></div>
                @endif
                <div class="flex items-center justify-between gap-2"><h2>{{ $firstReport['category'] }}</h2><x-status-badge :status="$firstReport['status']" /></div>
                <p>{{ $firstReport['location'] }} · {{ $firstReport['reported_ago'] }}</p>
                <a href="{{ route('reports.show', $firstReport['ticket_id']) }}">Lihat detail laporan →</a>
            @endif
        </div>
        <div class="map-controls" aria-label="Kontrol peta">
            <button type="button" aria-label="Perbesar peta" data-map-zoom="in"><span class="material-symbols-outlined" aria-hidden="true">add</span></button>
            <button type="button" aria-label="Perkecil peta" data-map-zoom="out"><span class="material-symbols-outlined" aria-hidden="true">remove</span></button>
            <button type="button" aria-label="Pusatkan lokasi saya" data-map-center><span class="material-symbols-outlined" aria-hidden="true">my_location</span></button>
        </div>
    @else
        <span class="mini-map-pin material-symbols-outlined" aria-hidden="true">location_on</span>
    @endif
</div>
