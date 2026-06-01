@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 32,
        'md' => 48,
        'lg' => 120,
        'xl' => 160,
    ];
    $px = $sizes[$size] ?? $sizes['md'];
@endphp

@if ($user->profilePictureUrl())
    <img src="{{ $user->profilePictureUrl() }}" alt="{{ $user->name }}"
         class="profile-avatar-img profile-avatar-img--{{ $size }}"
         style="width: {{ $px }}px; height: {{ $px }}px;">
@else
    <span class="profile-avatar-fallback profile-avatar-fallback--{{ $size }}"
          style="width: {{ $px }}px; height: {{ $px }}px; font-size: {{ $px * 0.38 }}px;">
        {{ $user->initials() }}
    </span>
@endif
