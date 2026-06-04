@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-page-header">
    <div>
        <h1>Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}. Here's what's happening.</p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon" style="background: rgba(95,158,160,0.12); color: #5f9ea0;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="admin-stat-value">{{ $totalUsers }}</div>
                <div class="admin-stat-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon" style="background: rgba(99,102,241,0.12); color: #6366f1;">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div>
                <div class="admin-stat-value">{{ $totalAdmins }}</div>
                <div class="admin-stat-label">Admins</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon" style="background: rgba(16,185,129,0.12); color: #10b981;">
                <i class="bi bi-journal-richtext"></i>
            </div>
            <div>
                <div class="admin-stat-value">{{ $totalEntries }}</div>
                <div class="admin-stat-label">Total Entries</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon" style="background: rgba(245,158,11,0.12); color: #f59e0b;">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <div>
                <div class="admin-stat-value">{{ $newUsersToday }}</div>
                <div class="admin-stat-label">New Today</div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Users --}}
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">Recent Users</h5>
        <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-outline" style="font-size:0.8rem; padding:0.35rem 0.85rem;">
            View All <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentUsers as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if ($user->profilePictureUrl())
                                <img src="{{ $user->profilePictureUrl() }}" class="admin-avatar" alt="">
                            @else
                                <span class="admin-avatar-initials">{{ $user->initials() }}</span>
                            @endif
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        @if ($user->is_admin)
                            <span class="badge badge-admin rounded-pill px-2">Admin</span>
                        @else
                            <span class="badge badge-user rounded-pill px-2">User</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn-admin btn-admin-outline"
                           style="font-size:0.75rem; padding:0.3rem 0.75rem;">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
