<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <h5 class="logo-title light-logo ml-3">Tailor Shop</h5>
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
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>

                <!-- Orders -->
                <li class="{{ request()->is('orders*') ? 'active' : '' }}">
                    <a href="#orders" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <path d="M3 9h18M9 21V9"></path>
                        </svg>
                        <span class="ml-4">Orders</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="orders" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                            <a href="{{ route('orders.index') }}">
                                <i class="las la-shopping-cart"></i>
                                <span>All Orders</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
                            <a href="{{ route('orders.create') }}">
                                <i class="las la-plus-circle"></i>
                                <span>New Order</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.pending') ? 'active' : '' }}">
                            <a href="{{ route('orders.pending') }}">
                                <i class="las la-clock"></i>
                                <span>Pending Orders</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.in-progress') ? 'active' : '' }}">
                            <a href="{{ route('orders.in-progress') }}">
                                <i class="las la-tasks"></i>
                                <span>In Progress</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.completed') ? 'active' : '' }}">
                            <a href="{{ route('orders.completed') }}">
                                <i class="las la-check-circle"></i>
                                <span>Completed</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Customers -->
                <li class="{{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="#customers" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ml-4">Customers</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="customers" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('customers.index') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}">
                                <i class="las la-users"></i>
                                <span>All Customers</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('customers.create') ? 'active' : '' }}">
                            <a href="{{ route('customers.create') }}">
                                <i class="las la-user-plus"></i>
                                <span>Add Customer</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Tailors -->
                <li class="{{ request()->is('tailors*') ? 'active' : '' }}">
                    <a href="#tailors" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="ml-4">Tailors</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="tailors" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('tailors.index') ? 'active' : '' }}">
                            <a href="{{ route('tailors.index') }}">
                                <i class="las la-layer-group"></i>
                                <span>All Tailors</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('tailors.create') ? 'active' : '' }}">
                            <a href="{{ route('tailors.create') }}">
                                <i class="las la-user-plus"></i>
                                <span>Add Tailor</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('tailor-assignments.index') ? 'active' : '' }}">
                            <a href="{{ route('tailor-assignments.index') }}">
                                <i class="las la-tasks"></i>
                                <span>Assignments</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Dress Types -->
                <li class="{{ request()->is('dress-types*') ? 'active' : '' }}">
                    <a href="{{ route('dress-types.index') }}" class="svg-icon">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7" y2="7"></line>
                        </svg>
                        <span class="ml-4">Dress Types</span>
                    </a>
                </li>

                <!-- Fabrics -->
                <li class="{{ request()->is('fabrics*') ? 'active' : '' }}">
                    <a href="#fabrics" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg>
                        <span class="ml-4">Fabrics</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="fabrics" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('fabrics.index') ? 'active' : '' }}">
                            <a href="{{ route('fabrics.index') }}">
                                <i class="las la-layer-group"></i>
                                <span>Fabric Inventory</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('fabrics.create') ? 'active' : '' }}">
                            <a href="{{ route('fabrics.create') }}">
                                <i class="las la-plus-circle"></i>
                                <span>Add Fabric</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Payments -->
                <li class="{{ request()->is('payments*') ? 'active' : '' }}">
                    <a href="#payments" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        <span class="ml-4">Payments</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="payments" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('payments.index') ? 'active' : '' }}">
                            <a href="{{ route('payments.index') }}">
                                <i class="las la-money-bill-wave"></i>
                                <span>All Payments</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('payments.create') ? 'active' : '' }}">
                            <a href="{{ route('payments.create') }}">
                                <i class="las la-plus-circle"></i>
                                <span>Receive Payment</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('payments.overdue') ? 'active' : '' }}">
                            <a href="{{ route('payments.overdue') }}">
                                <i class="las la-exclamation-circle"></i>
                                <span>Overdue</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Expenses -->
                <li class="{{ request()->is('expenses*') ? 'active' : '' }}">
                    <a href="{{ route('expenses.index') }}" class="svg-icon">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        <span class="ml-4">Expenses</span>
                    </a>
                </li>

                <!-- Reports -->
                <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                    <a href="#reports" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="ml-4">Reports</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                            <a href="{{ route('reports.sales') }}">
                                <i class="las la-chart-bar"></i>
                                <span>Sales Report</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.tailor-performance') ? 'active' : '' }}">
                            <a href="{{ route('reports.tailor-performance') }}">
                                <i class="las la-user-chart"></i>
                                <span>Tailor Performance</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}">
                            <a href="{{ route('reports.inventory') }}">
                                <i class="las la-boxes"></i>
                                <span>Inventory Report</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.financial') ? 'active' : '' }}">
                            <a href="{{ route('reports.financial') }}">
                                <i class="las la-file-invoice-dollar"></i>
                                <span>Financial Report</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                    <a href="#settings" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        <span class="ml-4">Settings</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('settings.general') ? 'active' : '' }}">
                            <a href="{{ route('settings.general') }}">
                                <i class="las la-cog"></i>
                                <span>General Settings</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('branches.index') ? 'active' : '' }}">
                            <a href="{{ route('branches.index') }}">
                                <i class="las la-store"></i>
                                <span>Branches</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="las la-user-cog"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('discounts.index') ? 'active' : '' }}">
                            <a href="{{ route('discounts.index') }}">
                                <i class="las la-tags"></i>
                                <span>Discounts</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
    /* Fix sidebar height and scrolling */
    .iq-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        z-index: 1000;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .iq-sidebar-logo {
        flex-shrink: 0;
        height: 70px;
        padding: 0 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .data-scrollbar {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        height: calc(100vh - 70px) !important;
        max-height: calc(100vh - 70px) !important;
    }

    /* Ensure the menu takes full height */
    .iq-sidebar-menu {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    .iq-menu {
        flex: 1;
        padding-bottom: 20px; /* Add padding at bottom */
    }

    /* Custom scrollbar styling */
    .data-scrollbar::-webkit-scrollbar {
        width: 5px;
    }

    .data-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .data-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .data-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Fix submenu items visibility */
    .iq-submenu {
        max-height: 500px; /* Set a reasonable max height */
        overflow-y: auto;
        overflow-x: hidden;
    }

    .iq-submenu::-webkit-scrollbar {
        width: 3px;
    }

    .iq-submenu::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .iq-submenu::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    /* Ensure last items are visible */
    .iq-menu li:last-child {
        margin-bottom: 30px; /* Extra margin for last item */
    }

    /* Active menu styling */
    .iq-sidebar .iq-menu > li.active > a {
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

    /* Arrow rotation for active menu */
    .iq-arrow-right.arrow-active {
        transform: rotate(90deg);
        transition: transform 0.3s ease;
    }

    /* Fix for expanded menus - ensure they don't push content */
    .iq-submenu.collapse:not(.show) {
        display: none;
    }

    .iq-submenu.collapse.show {
        display: block;
        position: relative;
        z-index: 1;
    }

    /* Adjust main content when sidebar is open */
    .iq-sidebar.sidebar-default ~ .content-page {
        margin-left: 260px;
        transition: margin-left 0.3s ease;
    }

    @media (max-width: 991px) {
        .iq-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .iq-sidebar.sidebar-default.mobile-open {
            transform: translateX(0);
        }
        
        .iq-sidebar.sidebar-default ~ .content-page {
            margin-left: 0;
        }
    }
</style>