@if(session('success'))
    <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
@endif

@if(session('error'))
    <x-ui.alert type="danger">{{ session('error') }}</x-ui.alert>
@endif

@if(session('warning'))
    <x-ui.alert type="warning">{{ session('warning') }}</x-ui.alert>
@endif

@if(session('info'))
    <x-ui.alert type="info">{{ session('info') }}</x-ui.alert>
@endif

@if(isset($errors) && $errors->any())
    <x-ui.alert type="danger" :dismissible="true">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 pl-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif
