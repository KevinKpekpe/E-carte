<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | @yield('title', 'ecarte')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <div id="wrapper">

        <div class="navbar-custom">
            <div class="container-fluid ps-0">
                <ul class="list-unstyled topnav-menu float-end mb-0">
                    <li class="d-none d-lg-block">
                        <form class="app-search">
                            <div class="app-search-box">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search..." id="top-search">
                                    <button class="btn input-group-text" type="submit">
                                        <i class="fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li class="notification-list d-none d-lg-block">
                        <a href="javascript:void(0);" class="nav-link waves-effect waves-light" id="light-dark-mode"
                            type="button">
                            <i class="fe-sun noti-icon"></i>
                        </a>
                    </li>

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <img src="https://png.pngtree.com/png-vector/20240601/ourmid/pngtree-casual-man-flat-design-avatar-profile-picture-vector-png-image_12593008.png"
                                alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ms-1">
                                {{ auth()->user()->nom }}
                                <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">

                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>


                            <a href="{{ route('admin.profil') }}" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>Mon compte </span>
                            </a>

                            <form action="" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link">
                                    <i class="fas fa-lock"></i> Verrouiller l'écran
                                </button>
                            </form>

                            <div class="dropdown-divider"></div>


                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item notify-item">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark p-0"
                                    style="text-decoration: none;">
                                    <i class="fe-log-out"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>


                        </div>
                    </li>

                </ul>

                <div class="logo-box">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <h2 style="color:orange">E-CARTE</h2>
                        </span>
                        <span class="logo-lg">
                            <h2 style="color:orange">E-CARTE</h2>
                        </span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <h2 style="color:orange">E-CARTE</h2>
                        </span>
                        <span class="logo-lg">
                            <h2 style="color:orange">E-CARTE</h2>
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
                    <li class="">
                        <button class="button-menu-mobile waves-effect">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li class="d-none d-lg-flex">
                        <h4 class="page-title-main">Dashboard</h4>
                    </li>

                </ul>

                <div class="clearfix"></div>

            </div>
        </div>
