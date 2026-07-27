@extends('layouts.admin')
@section('title', 'Edit Role: ' . $role->name)
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.roles.update',$role) }}">
        @csrf @method('PUT')
        @foreach ($permissions as $module => $modulePermissions)
            <h6 class="text-uppercase text-muted mt-3">{{ $module }}</h6>
            <div class="row mb-2">
                @foreach ($modulePermissions as $permission)
                    <div class="col-md-2 col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}"
                                id="perm{{ $permission->id }}"
                                @checked($role->hasPermissionTo($permission->name))>
                            <label class="form-check-label" for="perm{{ $permission->id }}">{{ explode('.', $permission->name)[1] }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="mt-4">
            <button class="btn btn-primary">Save Permissions</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
