@extends('layouts.admin')

@section('title', $user->name)

@section('content')
<div class="admin-page-header">
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i> Back to Users
        </a>
        <h1 class="mt-1">{{ $user->name }}</h1>
        <p>User profile &amp; details</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-pencil"></i> Edit User
        </a>
        @if ($user->id !== auth()->id())
            <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-admin btn-admin-outline">
                    <i class="bi bi-shield{{ $user->is_admin ? '-x' : '-plus' }}"></i>
                    {{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}
                </button>
            </form>
        @endif
    </div>
</div>

<div class="row g-3">
    {{-- Avatar + quick stats --}}
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
            @if ($user->is_admin)
                <span class="badge badge-admin rounded-pill px-3">Admin</span>
            @else
                <span class="badge badge-user rounded-pill px-3">User</span>
            @endif

            <hr class="my-3">

            <div class="text-start small">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Journal entries</span>
                    <span class="fw-semibold">{{ $user->journal_entries_count }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Member since</span>
                    <span class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Last updated</span>
                    <span class="fw-semibold">{{ $user->updated_at->format('M d, Y') }}</span>
                </div>
            </div>

            @if ($user->id !== auth()->id())
                <div class="mt-3">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Delete this user permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger w-100">
                            <i class="bi bi-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    {{-- Details --}}
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
                @if ($user->bio)
                    <div class="profile-info-item profile-info-item--full">
                        <span class="profile-info-label"><i class="bi bi-chat-left-text me-1"></i> Bio</span>
                        <span class="profile-info-value">{{ $user->bio }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
