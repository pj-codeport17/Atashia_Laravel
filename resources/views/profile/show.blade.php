@extends('layouts.app')

@section('title', 'My Profile - Daily Journal')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <h1>My Profile</h1>
        <p>Your account information</p>
    </div>
    <a href="{{ route('profile.edit') }}" class="btn-dj-primary" style="width: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
        <i class="bi bi-pencil me-1"></i> Edit Profile
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="chart-card text-center profile-card-side">
            <div class="profile-picture-wrap mx-auto mb-3">
                @include('partials.user-avatar', ['user' => $user, 'size' => 'xl'])
            </div>
            <h2 class="h5 fw-bold mb-1">{{ $user->name }}</h2>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            @if ($user->bio)
                <p class="small text-muted mb-0">{{ $user->bio }}</p>
            @endif
            <hr class="my-4">
            <div class="text-start small">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Journal entries</span>
                    <span class="fw-semibold">{{ $user->journalEntries()->count() }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Member since</span>
                    <span class="fw-semibold">{{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="chart-card">
            <h5 class="fw-semibold mb-4">Personal Information</h5>

            <div class="profile-info-grid">
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-person me-2"></i>Full name</span>
                    <span class="profile-info-value">{{ $user->name }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-envelope me-2"></i>Email</span>
                    <span class="profile-info-value">{{ $user->email }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-telephone me-2"></i>Phone</span>
                    <span class="profile-info-value">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-gender-ambiguous me-2"></i>Gender</span>
                    <span class="profile-info-value">{{ $user->genderLabel() ?? '—' }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-calendar-event me-2"></i>Date of birth</span>
                    <span class="profile-info-value">
                        {{ $user->date_of_birth ? $user->date_of_birth->format('F j, Y') : '—' }}
                    </span>
                </div>
                <div class="profile-info-item profile-info-item--full">
                    <span class="profile-info-label"><i class="bi bi-geo-alt me-2"></i>Address</span>
                    <span class="profile-info-value">
                        @if ($user->address || $user->city || $user->country)
                            {{ collect([$user->address, $user->city, $user->country])->filter()->join(', ') }}
                        @else
                            —
                        @endif
                    </span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <a href="{{ route('profile.edit') }}" class="btn-dj-primary" style="width: auto; display: inline-flex;">
                    <i class="bi bi-pencil-square me-1"></i> Update Information
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
