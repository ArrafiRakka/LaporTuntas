@props(['status'])
<span {{ $attributes->merge(['class' => 'status-badge status-'.str_replace(' ', '-', $status)]) }}>{{ $status }}</span>
