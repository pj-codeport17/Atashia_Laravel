@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="admin-page-header">
    <div>
        <h1>User Management</h1>
        <p>{{ $users->total() }} {{ Str::plural('user', $users->total()) }} registered</p>
    </div>
</div>

{{-- Search & Filter --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="admin-search">
    <input type="text" name="search" placeholder="Search name or email…"
           value="{{ request('search') }}" style="min-width: 220px;">
    <select name="role">
        <option value="">All Roles</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
    </select>
    <button type="submit" class="btn-admin btn-admin-primary">
        <i class="bi bi-search"></i> Search
    </button>
    @if (request('search') || request('role'))
        <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-x"></i> Clear
        </a>
    @endif
</form>

<div class="admin-card p-0" style="overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="padding-left:1.5rem;">User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Entries</th>
                <th>Joined</th>
                <th style="padding-right:1.5rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td style="padding-left:1.5rem;">
                        <div class="d-flex align-items-center gap-2">
                            @if ($user->profilePictureUrl())
                                <img src="{{ $user->profilePictureUrl() }}" class="admin-avatar" alt="">
                            @else
                                <span class="admin-avatar-initials">{{ $user->initials() }}</span>
                            @endif
                            <div>
                                <div class="fw-semibold" style="font-size:0.875rem;">{{ $user->name }}</div>
                                @if ($user->city || $user->country)
                                    <div class="text-muted" style="font-size:0.75rem;">
                                        {{ collect([$user->city, $user->country])->filter()->join(', ') }}
                                    </div>
                                @endif
                            </div>
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
                    <td class="text-muted">{{ $user->journal_entries_count ?? $user->journalEntries()->count() }}</td>
                    <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="padding-right:1.5rem;">
                        <div class="d-flex align-items-center gap-1 flex-wrap">
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="btn-admin btn-admin-outline" style="font-size:0.75rem; padding:0.3rem 0.65rem;"
                               title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn-admin btn-admin-outline" style="font-size:0.75rem; padding:0.3rem 0.65rem;"
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            {{-- Toggle Admin --}}
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="btn-admin {{ $user->is_admin ? 'btn-admin-outline' : 'btn-admin-primary' }}"
                                        style="font-size:0.75rem; padding:0.3rem 0.65rem;"
                                        title="{{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}">
                                        <i class="bi bi-shield{{ $user->is_admin ? '-x' : '-plus' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="btn-admin btn-admin-danger"
                                        style="font-size:0.75rem; padding:0.3rem 0.65rem;"
                                        title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-people d-block mb-2" style="font-size:2rem; opacity:0.3;"></i>
                        No users found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($users->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
