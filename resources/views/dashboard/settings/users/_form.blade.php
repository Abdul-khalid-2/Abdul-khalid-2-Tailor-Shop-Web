@php
    $isEdit = $user !== null;
    $currentRole = old('role', $isEdit ? ($user->roles->first()?->name ?? 'admin') : 'admin');
@endphp

<form action="{{ $isEdit ? route('settings.users.update', $user) : route('settings.users.store') }}" method="POST">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="form-group">
        <label for="name">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user?->name) }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user?->email) }}" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user?->phone) }}">
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="password">Password @if(!$isEdit)<span class="text-danger">*</span>@endif</label>
            <input type="password" name="password" id="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
            @if($isEdit)<small class="text-muted">Leave blank to keep current password</small>@endif
        </div>
        <div class="col-md-6 form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="role">Role <span class="text-danger">*</span></label>
            <select name="role" id="role" class="form-control" required>
                <option value="superadmin" @selected($currentRole === 'superadmin')>Super Admin</option>
                <option value="admin" @selected($currentRole === 'admin')>Branch Admin</option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control" required>
                @foreach(['active', 'inactive', 'suspended'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $user?->status ?? 'active') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="branch_id">Branch</label>
        <select name="branch_id" id="branch_id" class="form-control">
            <option value="">— None (Super Admin) —</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" @selected(old('branch_id', $user?->branch_id) == $branch->id)>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Required for Branch Admin accounts</small>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="las la-save mr-1"></i> {{ $isEdit ? 'Update User' : 'Create User' }}
    </button>
</form>
