@props(['report', 'selected' => false])
<a href="{{ route('reports.show', $report['ticket_id']) }}" class="report-card {{ $selected ? 'is-selected' : '' }}" data-report-card data-ticket="{{ $report['ticket_id'] }}" data-category="{{ $report['category_key'] }}" data-status="{{ $report['status'] }}" data-distance="{{ $report['distance_km'] ?? 1 }}">
    <span class="category-icon material-symbols-outlined" aria-hidden="true">{{ config('lapor_tuntas.categories.'.$report['category_key'].'.icon', 'location_on') }}</span>
    <span class="report-card-content">
        <span class="flex items-center justify-between gap-2"><span class="report-card-title" data-title>{{ $report['title'] }}</span><x-status-badge :status="$report['status']" /></span>
        <span class="report-card-meta">{{ $report['location'] }} · {{ $report['reported_ago'] }} · <code>{{ $report['ticket_id'] }}</code></span>
    </span>
</a>
