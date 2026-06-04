<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Daily Journal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        :root {
            --admin-sidebar-w: 240px;
            --admin-topbar-h: 60px;
            --admin-accent: #5f9ea0;
            --admin-accent-hover: #4d8a8c;
            --admin-sidebar-bg: #1a2332;
            --admin-sidebar-text: rgba(255,255,255,0.75);
            --admin-sidebar-text-hover: #fff;
            --admin-sidebar-active-bg: rgba(95,158,160,0.18);
            --admin-sidebar-active-text: #7ecacb;
        }

        body { background: #f0f2f5; font-family: var(--dj-font); }

        /* ── Sidebar ── */
        .admin-sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--admin-sidebar-w);
            height: 100vh;
            background: var(--admin-sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }

        .admin-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 1.25rem 1.25rem 1rem;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .admin-sidebar-brand .brand-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: var(--admin-accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .admin-sidebar-brand small {
            display: block;
            font-size: 0.65rem;
            font-weight: 400;
            color: var(--admin-sidebar-text);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            line-height: 1;
            margin-top: 1px;
        }

        .admin-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            list-style: none;
            margin: 0;
        }

        .admin-nav-section {
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            padding: 0.75rem 0.5rem 0.375rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            color: var(--admin-sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }

        .admin-nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: var(--admin-sidebar-text-hover);
        }

        .admin-nav-link.active {
            background: var(--admin-sidebar-active-bg);
            color: var(--admin-sidebar-active-text);
        }

        .admin-nav-link i { font-size: 1rem; width: 18px; text-align: center; }

        .admin-sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .admin-sidebar-footer .admin-nav-link { margin-bottom: 0; }

        /* ── Main area ── */
        .admin-main {
            margin-left: var(--admin-sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .admin-topbar {
            height: var(--admin-topbar-h);
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-topbar-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
            flex: 1;
        }

        .admin-topbar .user-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        /* ── Content ── */
        .admin-content {
            flex: 1;
            padding: 1.75rem;
        }

        /* ── Cards ── */
        .admin-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        .admin-stat-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        .admin-stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .admin-stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
            color: #1a1a1a;
        }

        .admin-stat-label {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 2px;
        }

        /* ── Table ── */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; }

        .admin-table th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .admin-table th:first-child { border-radius: 8px 0 0 0; }
        .admin-table th:last-child  { border-radius: 0 8px 0 0; }

        .admin-table td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.875rem;
            color: #374151;
        }

        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: #f9fafb; }

        /* ── Badges ── */
        .badge-admin { background: rgba(95,158,160,0.15); color: #2d7a7c; font-weight: 600; }
        .badge-user  { background: #f3f4f6; color: #6b7280; font-weight: 500; }

        /* ── Page header ── */
        .admin-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .admin-page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #1a1a1a;
        }

        .admin-page-header p {
            margin: 0.25rem 0 0;
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* ── Avatar ── */
        .admin-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .admin-avatar-initials {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--admin-accent);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .admin-avatar-initials.lg {
            width: 80px; height: 80px;
            font-size: 1.5rem;
        }

        /* ── Btn accent ── */
        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.15s;
        }

        .btn-admin:hover { opacity: 0.88; }
        .btn-admin-primary { background: var(--admin-accent); color: #fff; }
        .btn-admin-outline { background: transparent; border: 1.5px solid #d1d5db; color: #374151; }
        .btn-admin-danger  { background: #fee2e2; color: #dc2626; }

        /* ── Search bar ── */
        .admin-search {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .admin-search input,
        .admin-search select {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.45rem 0.85rem;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.15s;
        }

        .admin-search input:focus,
        .admin-search select:focus { border-color: var(--admin-accent); }

        /* ── Profile info grid (reuse user style) ── */
        .profile-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
        .profile-info-item {
            display: flex; flex-direction: column;
            padding: 0.875rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .profile-info-item--full { grid-column: 1 / -1; }
        .profile-info-label { font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem; }
        .profile-info-value { font-size: 0.9rem; font-weight: 500; color: #1a1a1a; }

        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-main { margin-left: 0; }
            .profile-info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- Sidebar --}}
<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand">
        <div class="brand-icon"><i class="bi bi-shield-check"></i></div>
        <div>
            Daily Journal
            <small>Admin Panel</small>
        </div>
    </a>

    <ul class="admin-nav">
        <li class="admin-nav-section">Main</li>
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </li>

        <li class="admin-nav-section">Management</li>
        <li>
            <a href="{{ route('admin.users.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>

        <li class="admin-nav-section">Account</li>
        <li>
            <a href="{{ route('admin.profile.show') }}"
               class="admin-nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
        </li>

    </ul>

    <div class="admin-sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="admin-nav-link w-100 border-0 bg-transparent text-start" style="cursor:pointer;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="admin-main">
    {{-- Topbar --}}
    <header class="admin-topbar">
        <span class="admin-topbar-title">@yield('title', 'Admin')</span>
        <div class="user-chip">
            @if (auth()->user()->profilePictureUrl())
                <img src="{{ auth()->user()->profilePictureUrl() }}" class="admin-avatar" alt="">
            @else
                <span class="admin-avatar-initials" style="width:32px;height:32px;font-size:0.7rem;">
                    {{ auth()->user()->initials() }}
                </span>
            @endif
            {{ auth()->user()->name }}
            <span class="badge badge-admin rounded-pill ms-1" style="font-size:0.65rem;">Admin</span>
        </div>
    </header>

    {{-- Toasts --}}
    @if (session('toast'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
            <div class="toast show align-items-center text-bg-{{ session('toast.type') }} border-0 rounded-3" role="alert">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">{{ session('toast.message') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Content --}}
    <main class="admin-content">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
