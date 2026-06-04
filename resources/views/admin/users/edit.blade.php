@extends('layouts.admin')

@section('title', 'Edit ' . $user->name)

@section('content')
<div class="admin-page-header">
    <div>
        <a href="{{ route('admin.users.show', $user) }}" class="text-muted text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i> Back to User
        </a>
        <h1 class="mt-1">Edit User</h1>
        <p>{{ $user->email }}</p>
    </div>
</div>

<div class="row g-3 justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Role</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_admin" value="0" id="role_user"
                                   {{ old('is_admin', $user->is_admin ? '1' : '0') == '0' ? 'checked' : '' }}
                                   {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <label class="form-check-label" for="role_user">User</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_admin" value="1" id="role_admin"
                                   {{ old('is_admin', $user->is_admin ? '1' : '0') == '1' ? 'checked' : '' }}
                                   {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <label class="form-check-label" for="role_admin">Admin</label>
                        </div>
                    </div>
                    @if ($user->id === auth()->id())
                        <small class="text-muted">You cannot change your own role.</small>
                    @endif
                </div>

                <hr class="my-4">

                {{-- Password --}}
                <p class="small text-muted mb-3">Leave password fields blank to keep the current password.</p>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           autocomplete="new-password">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn-admin btn-admin-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
