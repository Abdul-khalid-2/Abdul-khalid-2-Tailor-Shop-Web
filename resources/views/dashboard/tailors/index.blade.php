<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">Tailors</h4>
                <p class="mb-0 text-muted">Manage your tailor team and assignments</p>
            </div>
            <div>
                <a href="{{ route('tailors.create') }}" class="btn btn-primary">
                    <i class="las la-user-plus mr-1"></i> Add Tailor
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('tailors.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or phone..."
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="las la-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Active Orders</th>
                                <th class="text-center">Total Suits</th>
                                <th class="text-right">Fee Balance</th>
                                <th class="text-center" width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tailors as $tailor)
                                <tr>
                                    <td class="font-weight-bold">{{ $tailor->name }}</td>
                                    <td>{{ $tailor->phone }}</td>
                                    <td>
                                        <span class="badge badge-{{ $tailor->status === 'active' ? 'success' : 'warning' }}">
                                            {{ $tailor->status === 'active' ? 'Active' : 'On Leave' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary">{{ $tailor->active_orders_count }}</span>
                                    </td>
                                    <td class="text-center">{{ $tailor->total_suits_assigned }}</td>
                                    <td class="text-right {{ $tailor->total_fee_balance > 0 ? 'text-danger font-weight-bold' : '' }}">
                                        Rs {{ number_format($tailor->total_fee_balance, 0) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tailors.show', $tailor) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('tailors.edit', $tailor) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <form action="{{ route('tailors.destroy', $tailor) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this tailor?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="las la-cut fa-2x mb-2 d-block"></i>
                                        No tailors found.
                                        @if(request('search'))
                                            <a href="{{ route('tailors.index') }}" class="d-block mt-2">Clear search</a>
                                        @else
                                            <a href="{{ route('tailors.create') }}" class="btn btn-primary btn-sm mt-2">Add First Tailor</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($tailors->hasPages())
                <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
                    <small class="text-muted">
                        Showing {{ $tailors->firstItem() }} to {{ $tailors->lastItem() }} of {{ $tailors->total() }}
                    </small>
                    {{ $tailors->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
