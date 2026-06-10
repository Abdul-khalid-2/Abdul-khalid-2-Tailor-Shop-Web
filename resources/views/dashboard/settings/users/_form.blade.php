@php
    $isEdit = $user !== null;
    $currentRole = $isEdit ? ($user->roles->first()?->name ?? 'admin') : 'admin';
@endphp

<form action="{{ $isEdit ? route('settings.users.update', $user) : route('settings.users.store') }}" method="POST">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <x-ui.form.input name="name" label="Name" :value="$user?->name" required />
    <x-ui.form.input type="email" name="email" label="Email" :value="$user?->email" required />
    <x-ui.form.input name="phone" label="Phone" :value="$user?->phone" />

    <div class="row">
        <div class="col-md-6">
            <x-ui.form.input type="password" name="password" label="Password" :required="!$isEdit"
                :help="$isEdit ? 'Leave blank to keep current password' : null" />
        </div>
        <div class="col-md-6">
            <x-ui.form.input type="password" name="password_confirmation" label="Confirm Password" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-ui.form.select name="role" label="Role"
                :options="['superadmin' => 'Super Admin', 'admin' => 'Branch Admin']"
                :selected="$currentRole" required />
        </div>
        <div class="col-md-6">
            <x-ui.form.select name="status" label="Status"
                :options="['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended']"
                :selected="$user?->status ?? 'active'" required />
        </div>
    </div>

    <x-ui.form.select name="branch_id" label="Branch" :options="$branches" :selected="$user?->branch_id"
        placeholder="— None (Super Admin) —" help="Required for Branch Admin accounts" />

    <x-ui.button type="submit" icon="las la-save">{{ $isEdit ? 'Update User' : 'Create User' }}</x-ui.button>
</form>
