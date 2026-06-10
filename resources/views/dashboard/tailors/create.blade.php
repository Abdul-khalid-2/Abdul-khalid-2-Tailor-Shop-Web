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
                <h4 class="mb-1">Add Tailor</h4>
                <p class="mb-0 text-muted">Register a new tailor to your team</p>
            </div>
            <div>
                <a href="{{ route('tailors.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Tailors
                </a>
            </div>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('tailors.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control {{ isset($errors) && $errors->has('name') ? 'is-invalid' : '' }}"
                                               value="{{ old('name') }}" required>
                                        @if(isset($errors) && $errors->has('name'))
                                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" class="form-control {{ isset($errors) && $errors->has('phone') ? 'is-invalid' : '' }}"
                                               value="{{ old('phone') }}" required>
                                        @if(isset($errors) && $errors->has('phone'))
                                            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cnic">CNIC</label>
                                        <input type="text" name="cnic" id="cnic" class="form-control" value="{{ old('cnic') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="joining_date">Joining Date</label>
                                        <input type="date" name="joining_date" id="joining_date" class="form-control" value="{{ old('joining_date') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="specialty">Specialty</label>
                                        <select name="specialty" id="specialty" class="form-control">
                                            <option value="all" @selected(old('specialty', 'all') === 'all')>All</option>
                                            <option value="shalwar_kameez" @selected(old('specialty') === 'shalwar_kameez')>Shalwar Kameez</option>
                                            <option value="sherwani" @selected(old('specialty') === 'sherwani')>Sherwani</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch_id">Branch</label>
                                        <select name="branch_id" id="branch_id" class="form-control">
                                            <option value="">— Select branch —</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                            </div>

                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary">
                                    <i class="las la-save mr-1"></i> Save Tailor
                                </button>
                                <a href="{{ route('tailors.index') }}" class="btn btn-outline-secondary ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
