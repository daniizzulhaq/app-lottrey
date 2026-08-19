<header class="user-navbar">

    <a href="{{ route('dashboard') }}"
       class="logo">

        Lottery<span>Demo</span>

    </a>


    <div class="profile-area">

        <div>

            <div class="profile-name">
                {{ auth()->user()->name }}
            </div>

            <div class="profile-role">
                User
            </div>

        </div>


        <div class="avatar">

            {{ strtoupper(
                substr(auth()->user()->name, 0, 1)
            ) }}

        </div>

    </div>

</header>
