<header class="app-topbar">
    <div class="container">
        <nav class="top-nav-custom">
            <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center gap-2">
                @include('partials.logo', ['size' => 'sm'])
                <span>Daily Journal</span>
            </a>

            <div class="top-nav-links">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid me-1"></i> Dashboard
                </a>

                <a href="{{ route('journal.index') }}" class="nav-link {{ request()->routeIs('journal.index', 'journal.show', 'journal.edit') ? 'active' : '' }}">
                    <i class="bi bi-journal-text me-1"></i> My Entries
                </a>

                <a href="{{ route('journal.create') }}" class="nav-link {{ request()->routeIs('journal.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle me-1"></i> New Entry
                </a>

                <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person me-1"></i> Profile
                </a>
            </div>

            <div class="dropdown top-nav-user">
                <button class="user-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'sm'])
                    <span>{{ auth()->user()->name }}</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                    <li>
                        <span class="dropdown-item-text small text-muted">
                            {{ auth()->user()->email }}
                        </span>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="bi bi-person me-2"></i> My Profile
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="bi bi-pencil me-2"></i> Edit Profile
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>