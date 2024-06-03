<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <center>
                    <h3>SISTEM INFORMASI KAPEL ST. PIUS</h3>
                </center>
                <ul class="navbar-nav navbar-nav-right">
                    @if (auth()->check())
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                id="profileDropdown">
                                <img src="/assets/images/faces/face28.jpg" alt="profile" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                aria-labelledby="profileDropdown">
                                <a class="dropdown-item">
                                    <i class="ti-settings text-primary"></i>
                                    Settings
                                </a>
                                <a href="{{ route('logout') }}" class="dropdown-item">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="horizontal-menu-toggle">
                            <span class="ti-menu"></span>
                        </button>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <span class="menu-title">LOGIN</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item">
                    <a class="nav-link @if ($title == 'Home') active @endif" href="{{ route('index') }}">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/widgets/widgets.html">
                        <i class="ti-announcement menu-icon"></i>
                        <span class="menu-title">Berita</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/widgets/widgets.html">
                        <i class="ti-user menu-icon"></i>
                        <span class="menu-title">Biodata Romo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/widgets/widgets.html">
                        <i class="ti-calendar menu-icon"></i>
                        <span class="menu-title">Jadwal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/widgets/widgets.html">
                        <i class="ti-clipboard menu-icon"></i>
                        <span class="menu-title">Pengumuman</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
