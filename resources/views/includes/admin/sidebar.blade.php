
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::currentRouteName() == 'admin.' ? 'active' : '' }}">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Scarlet
    </div>

    <li class="nav-item {{ substr( Route::currentRouteName(), 0, 13 ) == 'admin.config.' ? 'active' : '' }}">
        <a class="nav-link" href="/admin/sk/config" >
            <i class="fas fa-fw fa-cog"></i>
            <span>{{ __('scarlet.configuration') }}</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ substr( Route::currentRouteName(), 0, 14 ) == 'admin.sk-admin' ? 'active' : '' }} ">

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#contentCollapsePages"
            aria-expanded="true" aria-controls="contentCollapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>CMS</span>
        </a>

        <div id="contentCollapsePages"
            class="collapse {{ substr( Route::currentRouteName(), 0, 14 ) == 'admin.sk-admin' ? 'show' : '' }} "
            aria-labelledby="headingPages" data-parent="#accordionSidebar"
            >

            <div class="bg-white py-2 collapse-inner rounded">

                @foreach ($areas as $area)

                    <a class="collapse-item" href="/admin/sk/{{$area->url}}"> {{$area->label}} </a>

                @endforeach

            </div>
        </div>

    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Configuration
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ substr( Route::currentRouteName(), 0, 11 ) == 'admin.users' ? 'active' : '' }} ">
        <a class="nav-link" href="/admin/users">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
