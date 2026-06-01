@props(['size' => 'lg'])

@php
    $sizes = [
        'sm' => ['wrap' => 48, 'icon' => 22],
        'md' => ['wrap' => 72, 'icon' => 32],
        'lg' => ['wrap' => 96, 'icon' => 42],
    ];
    $s = $sizes[$size] ?? $sizes['lg'];
@endphp

<div class="dj-logo-wrap dj-logo-wrap--{{ $size }}" style="width: {{ $s['wrap'] }}px; height: {{ $s['wrap'] }}px;">
    <svg width="{{ $s['icon'] }}" height="{{ $s['icon'] }}" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M4 5.5C4 4.12 5.12 3 6.5 3H17.5C18.88 3 20 4.12 20 5.5V18.5C20 19.88 18.88 21 17.5 21H6.5C5.12 21 4 19.88 4 18.5V5.5Z" stroke="currentColor" stroke-width="1.5"/>
        <path d="M8 7H16M8 11H16M8 15H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
    </svg>
</div>
