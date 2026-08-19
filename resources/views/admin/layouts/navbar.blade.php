<header class="navbar">

    <button
        class="mobile-menu-btn"
        onclick="toggleSidebar()">

        ☰

    </button>


    <div class="navbar-title">

        <h2>
            @yield('page-title', 'Dashboard')
        </h2>

        <p>
            Virtual Credit Lottery System
        </p>

    </div>


    <div class="navbar-right">

        <div class="admin-profile">

            <div class="admin-avatar">

                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

            </div>


            <div class="admin-profile-info">

                <div class="admin-name">
                    {{ auth()->user()->name }}
                </div>

                <div class="admin-role">
                    Administrator
                </div>

            </div>

        </div>


        <form method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button type="submit"
                    class="logout-btn">

                Logout

            </button>

        </form>

    </div>

</header>
