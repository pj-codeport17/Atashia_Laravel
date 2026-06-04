@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="admin-page-header">
    <div>
        <a href="{{ route('admin.profile.show') }}" class="text-muted text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i> Back to Profile
        </a>
        <h1 class="mt-1">Edit Profile</h1>
    </div>
</div>

<div class="row g-3 justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="admin-card">
                {{-- Photo --}}
                <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                    <div id="picturePreview">
                        @if ($user->profilePictureUrl())
                            <img src="{{ $user->profilePictureUrl() }}"
                                 style="width:72px;height:72px;border-radius:50%;object-fit:cover;" alt="">
                        @else
                            <span class="admin-avatar-initials" style="width:72px;height:72px;font-size:1.25rem;">
                                {{ $user->initials() }}
                            </span>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label fw-semibold small mb-1">Profile Photo</label>
                        <input type="file" name="profile_picture" id="profile_picture"
                               class="form-control form-control-sm @error('profile_picture') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if ($user->profile_picture)
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="remove_picture"
                                       name="remove_picture" value="1">
                                <label class="form-check-label text-danger small" for="remove_picture">
                                    Remove photo
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Core fields --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Phone</label>
                        <input type="text" name="phone" class="form-control form-control-sm @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Gender</label>
                        <select name="gender" class="form-select form-select-sm @error('gender') is-invalid @enderror">
                            <option value="">—</option>
                            @foreach (\App\Enums\Gender::cases() as $gender)
                                <option value="{{ $gender->value }}"
                                    {{ old('gender', $user->gender?->value) === $gender->value ? 'selected' : '' }}>
                                    {{ $gender->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                               class="form-control form-control-sm @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                        @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">Bio</label>
                        <textarea name="bio" rows="2" maxlength="500"
                                  class="form-control form-control-sm @error('bio') is-invalid @enderror"
                                  placeholder="Optional">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div class="accordion mt-3" id="adminProfileAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $errors->hasAny(['address','city','country']) ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#addrSection">
                                <i class="bi bi-geo-alt me-2"></i> Address
                                <span class="text-muted small ms-2 fw-normal">(optional)</span>
                            </button>
                        </h2>
                        <div id="addrSection"
                             class="accordion-collapse collapse {{ $errors->hasAny(['address','city','country']) ? 'show' : '' }}">
                            <div class="accordion-body pt-0">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small">Street</label>
                                        <input type="text" name="address"
                                               class="form-control form-control-sm @error('address') is-invalid @enderror"
                                               value="{{ old('address', $user->address) }}">
                                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">City</label>
                                        <input type="text" name="city"
                                               class="form-control form-control-sm @error('city') is-invalid @enderror"
                                               value="{{ old('city', $user->city) }}">
                                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Country</label>
                                        <input type="text" name="country"
                                               class="form-control form-control-sm @error('country') is-invalid @enderror"
                                               value="{{ old('country', $user->country) }}">
                                        @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $errors->hasAny(['password','password_confirmation']) ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#pwSection">
                                <i class="bi bi-shield-lock me-2"></i> Change Password
                                <span class="text-muted small ms-2 fw-normal">(optional)</span>
                            </button>
                        </h2>
                        <div id="pwSection"
                             class="accordion-collapse collapse {{ $errors->hasAny(['password','password_confirmation']) ? 'show' : '' }}">
                            <div class="accordion-body pt-0">
                                <p class="text-muted small mb-3">Leave blank to keep your current password.</p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">New Password</label>
                                        <input type="password" name="password"
                                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                                               autocomplete="new-password">
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.profile.show') }}" class="btn-admin btn-admin-outline">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('profile_picture')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('picturePreview').innerHTML =
                '<img src="' + ev.target.result + '" style="width:72px;height:72px;border-radius:50%;object-fit:cover;" alt="">';
        };
        reader.readAsDataURL(file);
        const rm = document.getElementById('remove_picture');
        if (rm) rm.checked = false;
    });
</script>
@endpush
