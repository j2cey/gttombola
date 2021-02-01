<nav class="main-header navbar navbar-expand-md navbar-light navbar-lightblue">
    <div class="container">
        <a href="/" class="navbar-brand"
           style="display: flex; align-items: center; justify-content: center; height: 100%; ">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="brand-image elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Admin-IT') }}</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/dashboards" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownTombola" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Tombolas</a>
                    <ul aria-labelledby="dropdownTombola" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/tombolas" class="nav-link">Liste</a>
                        </li>
                        <li class="nav-item">
                            <a href="/tombolas/create" class="nav-link">Nouvel</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Utilisateurs</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/users" class="nav-link">Liste</a>
                        </li>
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Profiles</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                <li class="nav-item">
                                    <a href="/roles" class="nav-link">Liste</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- SEARCH FORM -->
{{--            @include('layouts.admin02.nav.search')--}}
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
{{--        @include('layouts.admin02.nav.messages')--}}

        <!-- Notifications Dropdown Menu -->
{{--            @include('layouts.admin02.nav.notifications')--}}
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
            </li>
        </ul>
    </div>
</nav>
