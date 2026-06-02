<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Journal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="welcome-page">
        @include('partials.logo', ['size' => 'lg'])

        <h1>Daily Journal</h1>
        <p class="tagline">Start keeping track of your life</p>

        <div class="welcome-actions">
            <a href="{{ route('login') }}" class="btn-dj-primary">Get Started</a>
            <a href="{{ route('register') }}" class="btn-dj-secondary">Create an account</a>
        </div>

        <p class="welcome-footer">&copy; {{ date('Y') }} Daily Journal. All rights reserved.</p>
    </div>

    @include('partials.toasts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
