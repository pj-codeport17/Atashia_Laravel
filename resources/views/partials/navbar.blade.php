<header class="app-topbar">
    <div class="container">
        <nav class="navbar navbar-expand-lg py-0">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                @include('partials.logo', ['size' => 'sm'])
                Daily Journal
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('journal.index') }}" class="nav-link {{ request()->routeIs('journal.index', 'journal.show', 'journal.edit') ? 'active' : '' }}">
                            <i class="bi bi-journal-text me-1"></i> My Entries
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('journal.create') }}" class="nav-link {{ request()->routeIs('journal.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle me-1"></i> New Entry
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="bi bi-person me-1"></i> Profile
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="user-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'sm'])
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                            <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email }}</span></li>
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
                </div>
            </div>
        </nav>
    </div>
</header>
