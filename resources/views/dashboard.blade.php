<x-app-layout>

    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="p-4 text-center border-bottom">
                            <div class="mb-3">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-user text-primary fa-2x"></i>
                                </div>
                            </div>
                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                        </div>

                        <nav class="nav flex-column p-3">
                            <a href="#" class="nav-link py-3 px-4 rounded-3 mb-2 active">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                            <a href="#" class="nav-link py-3 px-4 rounded-3 mb-2">
                                <i class="fas fa-shopping-bag me-2"></i> Orders
                            </a>
                            <a href="#" class="nav-link py-3 px-4 rounded-3 mb-2">
                                <i class="fas fa-heart me-2"></i> Wishlist
                            </a>
                            <a href="#" class="nav-link py-3 px-4 rounded-3 mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i> Addresses
                            </a>
                            <a href="#" class="nav-link py-3 px-4 rounded-3 mb-2">
                                <i class="fas fa-cog me-2"></i> Account Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="nav-link py-3 px-4 rounded-3 mb-0">
                                @csrf
                                <button type="submit" class="btn btn-link text-start p-0 m-0 text-decoration-none w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Welcome Card -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Welcome back, {{ Auth::user()->name }}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your account today.</p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-shopping-bag text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">12</h5>
                                        <p class="text-muted mb-0">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-heart text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">8</h5>
                                        <p class="text-muted mb-0">Wishlist Items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-star text-warning fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">4.8</h5>
                                        <p class="text-muted mb-0">Average Rating</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0">Recent Orders</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-001</td>
                                        <td>15 Nov 2023</td>
                                        <td>2 Items</td>
                                        <td>PKR 15,500</td>
                                        <td><span class="badge bg-success">Delivered</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-002</td>
                                        <td>12 Nov 2023</td>
                                        <td>1 Item</td>
                                        <td>PKR 8,200</td>
                                        <td><span class="badge bg-warning">Processing</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>