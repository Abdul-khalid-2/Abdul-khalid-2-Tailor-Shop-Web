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
                        <span class="ml-4">{{ __('messages.dashboard') }}</span>
                    </a>
                </li>

                <!-- Orders -->
                <li class="{{ request()->is('orders*') ? 'active' : '' }}">
                    <a href="#orders" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <path d="M3 9h18M9 21V9"></path>
                        </svg>
                        <span class="ml-4">{{ __('messages.orders_menu') }}</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="orders" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                            <a href="{{ route('orders.index') }}">
                                <i class="las la-shopping-cart"></i>
                                <span>{{ __('messages.all_orders') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.pending') ? 'active' : '' }}">
                            <a href="{{ route('orders.pending') }}">
                                <i class="las la-clock"></i>
                                <span>{{ __('messages.pending_orders') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.in-progress') ? 'active' : '' }}">
                            <a href="{{ route('orders.in-progress') }}">
                                <i class="las la-tasks"></i>
                                <span>{{ __('messages.in_progress_orders') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('orders.completed') ? 'active' : '' }}">
                            <a href="{{ route('orders.completed') }}">
                                <i class="las la-check-circle"></i>
                                <span>{{ __('messages.completed_orders') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- People -->
                <li class="{{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="#customers" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ml-4">{{ __('messages.people_menu') }}</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="customers" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('customers.index') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}">
                                <i class="las la-users"></i>
                                <span>{{ __('messages.customers') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('tailors.index') ? 'active' : '' }}">
                            <a href="{{ route('tailors.index') }}">
                                <i class="las la-layer-group"></i>
                                <span>{{ __('messages.tailors') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('tailor-assignments.index') ? 'active' : '' }}">
                            <a href="{{ route('tailor-assignments.index') }}">
                                <i class="las la-tasks"></i>
                                <span>{{ __('messages.assignments') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="las la-user-cog"></i>
                                <span>{{ __('messages.users') }}</span>
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
                        <span class="ml-4">{{ __('messages.dress_types') }}</span>
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
                        <span class="ml-4">{{ __('messages.fabrics_menu') }}</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="fabrics" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('fabrics.index') ? 'active' : '' }}">
                            <a href="{{ route('fabrics.index') }}">
                                <i class="las la-layer-group"></i>
                                <span>{{ __('messages.fabric_inventory') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('fabrics.create') ? 'active' : '' }}">
                            <a href="{{ route('fabrics.create') }}">
                                <i class="las la-plus-circle"></i>
                                <span>{{ __('messages.add_fabric') }}</span>
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
                        <span class="ml-4">{{ __('messages.payments_menu') }}</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="payments" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('payments.index') ? 'active' : '' }}">
                            <a href="{{ route('payments.index') }}">
                                <i class="las la-money-bill-wave"></i>
                                <span>{{ __('messages.all_payments') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('payments.create') ? 'active' : '' }}">
                            <a href="{{ route('payments.create') }}">
                                <i class="las la-plus-circle"></i>
                                <span>{{ __('messages.receive_payment') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('payments.overdue') ? 'active' : '' }}">
                            <a href="{{ route('payments.overdue') }}">
                                <i class="las la-exclamation-circle"></i>
                                <span>{{ __('messages.overdue_payments') }}</span>
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
                        <span class="ml-4">{{ __('messages.expenses') }}</span>
                    </a>
                </li>

                <!-- Reports -->
                <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                    <a href="#reports" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="ml-4">{{ __('messages.reports_menu') }}</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                            <a href="{{ route('reports.sales') }}">
                                <i class="las la-chart-bar"></i>
                                <span>{{ __('messages.sales_report') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.tailor-performance') ? 'active' : '' }}">
                            <a href="{{ route('reports.tailor-performance') }}">
                                <i class="las la-user-chart"></i>
                                <span>{{ __('messages.tailor_performance') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}">
                            <a href="{{ route('reports.inventory') }}">
                                <i class="las la-boxes"></i>
                                <span>{{ __('messages.inventory_report') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.financial') ? 'active' : '' }}">
                            <a href="{{ route('reports.financial') }}">
                                <i class="las la-file-invoice-dollar"></i>
                                <span>{{ __('messages.financial_report') }}</span>
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
                        <span class="ml-4">{{ __('messages.settings_menu') }}</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="{{ request()->routeIs('settings.general') ? 'active' : '' }}">
                            <a href="{{ route('settings.general') }}">
                                <i class="las la-cog"></i>
                                <span>{{ __('messages.general_settings') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('branches.index') ? 'active' : '' }}">
                            <a href="{{ route('branches.index') }}">
                                <i class="las la-store"></i>
                                <span>{{ __('messages.branches') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('discounts.index') ? 'active' : '' }}">
                            <a href="{{ route('discounts.index') }}">
                                <i class="las la-tags"></i>
                                <span>{{ __('messages.discounts') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
    .sidebar-default {
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.data-scrollbar {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
}

.iq-sidebar-menu {
    min-height: 100%;
    padding-bottom: 20px; /* Add some padding at bottom */
}
</style>