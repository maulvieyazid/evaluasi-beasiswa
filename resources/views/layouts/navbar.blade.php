<!-- Navbar -->
<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-menu" type="button" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            Aplikasi Evaluasi Beasiswa
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" href="#" aria-label="Open user menu">
                    <div class="d-none d-md-block ps-2 me-2">
                        <div>{{ auth()->user()->nama }} ({{ auth()->user()->nik }})</div>
                        <div class="mt-1 small text-muted">
                            @php
                                $nama_bagian_user = auth()->user()->departemen->nama ?? null;
                            @endphp
                            {{ ucwords(strtolower($nama_bagian_user)) }}
                        </div>
                    </div>
                    <span class="avatar avatar-sm">
                        {{ auth()->user()->inisial }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>


<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">

                <ul class="navbar-nav">

                    <li class="nav-item {{ $navbar == 'home' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>

                    <li class="nav-item {{ $navbar == 'evaluasi' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('index-evaluasi-beasiswa') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 11l3 3l8 -8" />
                                    <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Evaluasi Beasiswa
                            </span>
                        </a>
                    </li>

                    <li class="nav-item {{ $navbar == 'histori' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('index-histori') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg class="icon icon-tabler icon-tabler-history" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 8l0 4l2 2"></path>
                                    <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Histori
                            </span>
                        </a>
                    </li>

                    @if (auth()->user()->is_penmaru)
                        <li class="nav-item {{ $navbar == 'master-syarat' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('index.master-syarat-beasiswa') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg class="icon icon-tabler icon-tabler-settings-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                        <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Maintenance Syarat Beasiswa
                                </span>
                            </a>
                        </li>
                    @endif


                </ul>

            </div>
        </div>
    </div>
</header>
