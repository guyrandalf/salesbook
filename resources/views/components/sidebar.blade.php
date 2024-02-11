<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ strtoupper(Auth::user()->role) }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <div class="sidebar-heading">
        Dashboard
    </div>
    @if (Auth::user()->role === 'admin')
    <li class="nav-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Sales Book</span></a>
    </li>
    @else
    <li class="nav-item {{ Route::currentRouteName() == 'rep.dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rep.dashboard') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Sales Book</span></a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">
    @if (Auth::user()->role === 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Products
        </div>

        <li class="nav-item {{ Route::currentRouteName() == 'admin.products' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.products') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Product List</span></a>
        </li>
    @endif
    @if (Auth::user()->role === 'rep')
        <div class="sidebar-heading">
            Products
        </div>
    @endif
    @if (Auth::user()->role === 'admin')
    <li class="nav-item {{ Route::currentRouteName() == 'admin.stock' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.stock') }}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Stock</span></a>
    </li>
    @else
    <li class="nav-item {{ Route::currentRouteName() == 'rep.stock' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rep.stock') }}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Stock</span></a>
    </li>
    @endif

    <hr class="sidebar-divider">
    @if (Auth::user()->role === 'admin')
        <div class="sidebar-heading">
            Sales Reps
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Route::currentRouteName() == 'admin.rep' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.rep') }}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Reps. List</span></a>
        </li>
        <hr class="sidebar-divider">
    @endif

    <div class="sidebar-heading">
        Account
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Route::currentRouteName() == 'user.setting' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.setting') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
