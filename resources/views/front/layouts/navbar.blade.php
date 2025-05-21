<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand" href="{{ route('front.home') }}">
            <img class="logo" src="{{ asset('front') }}/img/Logo Dark-01.png" alt="">
            <span class="tag">Exam System</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarMenu">
            <!-- Left-aligned Menu Items -->
            @if (!Route::is('front.exam-start'))
                <ul class="navbar-nav mx-auto  mb-2 mb-sm-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.join-exam') }}">Join Exam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/exams') }}"> Exam</a>
                     </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            @endif
        </div>

        @auth
            <div class="d-flex user-panel">
                <div class="dropdown">
                    <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" id="logoutDropdown"
                        data-bs-toggle="dropdown">
                        @if (auth()->user()->photo)
                            <img src="{{ asset(auth()->user()->photo) }}" class="me-2 rounded-circle" width="40"
                                height="40" alt="">
                        @elseif(auth()->user()->google_avater)
                            <img src="{{ auth()->user()->google_avater }}" class="me-2 rounded-circle" width="40"
                                height="40" alt="">
                        @else
                            <img src="{{ asset('front') }}/img/avater.png" class="me-2 rounded-circle" width="40"
                                height="40" alt="">
                        @endif

                        <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <span class="material-symbols-outlined me-2">person</span>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('password.change') }}">
                                <span class="material-symbols-outlined me-2">key</span>
                                Change Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <span class="material-symbols-outlined align-middle me-2">logout</span>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth

        {{-- not auth  --}}
        @guest
            <div class="d-flex user-panel">
                <div class="dropdown">
                    <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" id="logoutDropdown"
                        data-bs-toggle="dropdown">
                        <span class="material-symbols-outlined me-2">login</span>
                        Login
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('login') }}">
                                <span class="material-symbols-outlined me-2">login</span>
                                Login
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('register') }}">
                                <span class="material-symbols-outlined me-2">login</span>
                                Register
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endguest

    </div>
</nav>
