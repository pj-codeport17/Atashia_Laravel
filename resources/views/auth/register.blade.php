@extends('layouts.guest')

@section('title', 'Create Account - Daily Journal')

@section('content')
<div class="auth-card">
    <a href="{{ route('welcome') }}" class="auth-back"><i class="bi bi-arrow-left"></i> Back</a>

    @include('partials.logo', ['size' => 'md'])

    <h2>Create account</h2>
    <p class="auth-subtitle">Start keeping track of your life</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Your name" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-dj-primary mb-3">Create Account</button>

        <p class="text-center text-muted small mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: var(--dj-primary)">Sign in</a>
        </p>
    </form>
</div>
@endsection
