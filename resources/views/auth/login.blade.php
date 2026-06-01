@extends('layouts.guest')

@section('title', 'Sign In - Daily Journal')

@section('content')
<div class="auth-card">
    <a href="{{ route('welcome') }}" class="auth-back"><i class="bi bi-arrow-left"></i> Back</a>

    @include('partials.logo', ['size' => 'md'])

    <h2>Welcome back</h2>
    <p class="auth-subtitle">Sign in to continue your journal</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
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

        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn-dj-primary mb-3">Sign In</button>

        <p class="text-center text-muted small mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: var(--dj-primary)">Create an account</a>
        </p>
    </form>
</div>
@endsection
