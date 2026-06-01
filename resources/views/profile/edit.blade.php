@extends('layouts.app')

@section('title', 'Edit Profile - Daily Journal')

@section('content')
<div class="page-header mb-3">
    <a href="{{ route('profile.show') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left"></i> Back to profile
    </a>
    <h1 class="mt-2 mb-0">Edit Profile</h1>
</div>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-edit-form">
    @csrf
    @method('PUT')

    <div class="chart-card profile-edit-card">
        {{-- Photo + core fields (always visible) --}}
        <div class="profile-edit-header d-flex flex-wrap align-items-center gap-3 mb-4 pb-4 border-bottom">
            <div class="profile-picture-preview flex-shrink-0" id="picturePreview">
                @include('partials.user-avatar', ['user' => $user, 'size' => 'lg'])
            </div>
            <div class="flex-grow-1" style="min-width: 200px;">
                <label for="profile_picture" class="form-label small mb-1">Profile photo</label>
                <input type="file" class="form-control form-control-sm @error('profile_picture') is-invalid @enderror"
                       id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                @error('profile_picture')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                @if ($user->profile_picture)
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" id="remove_picture" name="remove_picture" value="1">
                        <label class="form-check-label text-danger small" for="remove_picture">Remove photo</label>
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Full name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name"
                       value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone"
                       value="{{ old('phone', $user->phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select form-select-sm @error('gender') is-invalid @enderror" id="gender" name="gender">
                    <option value="">—</option>
                    @foreach (\App\Enums\Gender::cases() as $gender)
                        <option value="{{ $gender->value }}" {{ old('gender', $user->gender?->value) === $gender->value ? 'selected' : '' }}>
                            {{ $gender->label() }}
                        </option>
                    @endforeach
                </select>
                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="date_of_birth" class="form-label">Date of birth</label>
                <input type="date" class="form-control form-control-sm @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth"
                       value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control form-control-sm @error('bio') is-invalid @enderror" id="bio" name="bio" rows="2"
                          maxlength="500" placeholder="Optional">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Collapsible: Address --}}
        <div class="accordion profile-edit-accordion mt-3" id="profileEditAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $errors->hasAny(['address', 'city', 'country']) ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#addressSection">
                        <i class="bi bi-geo-alt me-2"></i> Address
                        <span class="text-muted small ms-2 fw-normal">(optional)</span>
                    </button>
                </h2>
                <div id="addressSection" class="accordion-collapse collapse {{ $errors->hasAny(['address', 'city', 'country']) ? 'show' : '' }}"
                     data-bs-parent="#profileEditAccordion">
                    <div class="accordion-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="address" class="form-label">Street</label>
                                <input type="text" class="form-control form-control-sm @error('address') is-invalid @enderror" id="address" name="address"
                                       value="{{ old('address', $user->address) }}">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control form-control-sm @error('city') is-invalid @enderror" id="city" name="city"
                                       value="{{ old('city', $user->city) }}">
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control form-control-sm @error('country') is-invalid @enderror" id="country" name="country"
                                       value="{{ old('country', $user->country) }}">
                                @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $errors->hasAny(['password', 'password_confirmation']) ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#passwordSection">
                        <i class="bi bi-shield-lock me-2"></i> Change password
                        <span class="text-muted small ms-2 fw-normal">(optional)</span>
                    </button>
                </h2>
                <div id="passwordSection" class="accordion-collapse collapse {{ $errors->hasAny(['password', 'password_confirmation']) ? 'show' : '' }}"
                     data-bs-parent="#profileEditAccordion">
                    <div class="accordion-body pt-0">
                        <p class="text-muted small mb-3">Leave blank to keep your current password.</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">New password</label>
                                <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm password</label>
                                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
            <button type="submit" class="btn-dj-primary profile-edit-submit">
                <i class="bi bi-check-lg me-1"></i> Save changes
            </button>
            <a href="{{ route('profile.show') }}" class="btn-dj-secondary profile-edit-cancel">Cancel</a>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('profile_picture')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('picturePreview').innerHTML =
                '<img src="' + ev.target.result + '" alt="Preview" class="profile-avatar-img profile-avatar-img--lg" style="width:96px;height:96px;border-radius:50%;object-fit:cover;">';
        };
        reader.readAsDataURL(file);
        document.getElementById('remove_picture') && (document.getElementById('remove_picture').checked = false);
    });
</script>
@endpush
