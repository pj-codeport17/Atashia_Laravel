@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="admin-page-header">
    <div>
        <h1>My Profile</h1>
        <p>Your admin account information</p>
    </div>
    <a href="{{ route('admin.profile.edit') }}" class="btn-admin btn-admin-primary">
        <i class="bi bi-pencil"></i> Edit Profile
    </a>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="admin-card text-center">
            <div class="mb-3">
                @if ($user->profilePictureUrl())
                    <img src="{{ $user->profilePictureUrl() }}"
                         style="width:80px;height:80px;border-radius:50%;object-fit:cover;" alt="">
                @else
                    <span class="admin-avatar-initials lg mx-auto">{{ $user->initials() }}</span>
                @endif
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            <span class="badge badge-admin rounded-pill px-3">Admin</span>

            @if ($user->bio)
                <p class="small text-muted mt-3 mb-0">{{ $user->bio }}</p>
            @endif

            <hr class="my-3">

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
        <div class="admin-card">
            <h5 class="fw-semibold mb-4">Personal Information</h5>
            <div class="profile-info-grid">
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-person me-1"></i> Full Name</span>
                    <span class="profile-info-value">{{ $user->name }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-envelope me-1"></i> Email</span>
                    <span class="profile-info-value">{{ $user->email }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-telephone me-1"></i> Phone</span>
                    <span class="profile-info-value">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-gender-ambiguous me-1"></i> Gender</span>
                    <span class="profile-info-value">{{ $user->genderLabel() ?? '—' }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label"><i class="bi bi-calendar me-1"></i> Date of Birth</span>
                    <span class="profile-info-value">
                        {{ $user->date_of_birth ? $user->date_of_birth->format('F j, Y') : '—' }}
                    </span>
                </div>
                <div class="profile-info-item profile-info-item--full">
                    <span class="profile-info-label"><i class="bi bi-geo-alt me-1"></i> Address</span>
                    <span class="profile-info-value">
                        {{ collect([$user->address, $user->city, $user->country])->filter()->join(', ') ?: '—' }}
                    </span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-top">
                <a href="{{ route('admin.profile.edit') }}" class="btn-admin btn-admin-primary">
                    <i class="bi bi-pencil-square"></i> Update Information
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
