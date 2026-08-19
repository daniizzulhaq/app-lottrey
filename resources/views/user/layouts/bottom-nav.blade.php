<nav class="bottom-nav">

    <div class="bottom-nav-inner">

        <a href="{{ route('dashboard') }}"
           class="bottom-item
           {{ request()->routeIs('dashboard')
                ? 'active'
                : '' }}">

            <span class="bottom-icon">
                🏠
            </span>

            Home

        </a>


        <a href="{{ route('games.index') }}"
           class="bottom-item
           {{ request()->routeIs('games.*')
                ? 'active'
                : '' }}">

            <span class="bottom-icon">
                🎮
            </span>

            Game

        </a>


        <a href="{{ route('history.index') }}"
           class="bottom-item
           {{ request()->routeIs('history.*')
                ? 'active'
                : '' }}">

            <span class="bottom-icon">
                📋
            </span>

            History

        </a>


        <a href="#"
           class="bottom-item">

            <span class="bottom-icon">
                💬
            </span>

            Customer

        </a>


        <a href="#"
           class="bottom-item">

            <span class="bottom-icon">
                👤
            </span>

            Account

        </a>

    </div>

</nav>
