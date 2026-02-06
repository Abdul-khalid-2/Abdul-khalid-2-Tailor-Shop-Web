<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="#" class="header-logo">
            <h5 class="logo-title light-logo ml-3">Tailor Shop SHOP</h5>
        </a>
        <div class="iq-menu-bt-sidebar ml-0">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <!-- Dashboard -->
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="svg-icon">
                        <svg class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>

                <!-- Products -->
                <li class="{{ request()->is('products*') ? 'active' : '' }}">
                    <a href="#products" class="collapsed" data-toggle="collapse" aria-expanded="{{ request()->is('products*') ? 'true' : 'false' }}">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7" y2="7"></line>
                        </svg>
                        <span class="ml-4">Products</span>
                        <svg class="svg-icon iq-arrow-right {{ request()->is('products*') ? 'arrow-active' : '' }}" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="products" class="iq-submenu collapse {{ request()->is('products*') ? 'show' : '' }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <a href="#">
                                <i class="las la-minus"></i>
                                <span>All Products</span>
                            </a>
                        </li>

                    </ul>
                </li>




            </ul>
        </nav>
    </div>
</div>

<style>
    .iq-sidebar .iq-menu li a i {
        width: 20px;
        text-align: center;
        margin-right: 10px;
    }

    .iq-sidebar .iq-submenu li a i.las.la-minus {
        font-size: 10px;
    }

    /* Active menu styling */
    .iq-sidebar .iq-menu>li.active>a {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
        border-left: 3px solid #3B82F6;
    }

    .iq-sidebar .iq-submenu li.active a {
        color: #3B82F6;
        font-weight: 500;
    }

    .iq-sidebar .iq-submenu {
        padding-left: 20px;
    }

    .iq-sidebar .iq-submenu li {
        margin: 5px 0;
    }
</style>