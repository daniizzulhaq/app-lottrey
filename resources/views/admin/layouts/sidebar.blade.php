<aside class="sidebar">

    <div class="sidebar-logo">

        <div>

            <h1>
                Lottery<span>Admin</span>
            </h1>

            <p>
                Virtual Credit System
            </p>

        </div>

    </div>


    <div class="sidebar-menu">

        <div class="menu-title">
            Main Menu
        </div>


        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <span class="menu-icon">🏠</span>

            <span>
                Dashboard
            </span>

        </a>


        <div class="menu-title">
            Management
        </div>


        <a href="{{ route('admin.users.index') }}"
           class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

            <span class="menu-icon">👥</span>

            <span>
                Users
            </span>

        </a>


        <a href="{{ route('admin.games.index') }}"
           class="menu-item {{ request()->routeIs('admin.games.*') ? 'active' : '' }}">

            <span class="menu-icon">🎮</span>

            <span>
                Games
            </span>

        </a>


        <a href="{{ route('admin.draws.index') }}"
           class="menu-item {{ request()->routeIs('admin.draws.*') ? 'active' : '' }}">

            <span class="menu-icon">🎱</span>

            <span>
                Draws
            </span>

        </a>


        <a href="{{ route('admin.topups.index') }}"
           class="menu-item {{ request()->routeIs('admin.topups.*') ? 'active' : '' }}">

            <span class="menu-icon">💳</span>

            <span>
                Top Up
            </span>

        </a>


        <a href="{{ route('admin.redemptions.index') }}"
           class="menu-item {{ request()->routeIs('admin.redemptions.*') ? 'active' : '' }}">

            <span class="menu-icon">💰</span>

            <span>
                Redeem
            </span>

        </a>


        <a href="{{ route('admin.transactions.index') }}"
           class="menu-item {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">

            <span class="menu-icon">📊</span>

            <span>
                Transactions
            </span>

        </a>


        <div class="menu-title">
            System
        </div>


        <a href="{{ route('admin.settings.index') }}"
           class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">

            <span class="menu-icon">⚙️</span>

            <span>
                Settings
            </span>

        </a>

    </div>


    <div class="sidebar-user">

        <div class="sidebar-user-box">

            <div style="font-size: 10px; color: #64748b;">
                Logged in as
            </div>

            <div class="sidebar-user-name">
                {{ auth()->user()->name }}
            </div>

            <div class="sidebar-user-role">
                Administrator
            </div>

        </div>

    </div>

</aside>
