@extends('layouts.admin')
@section('title', 'Roles & Permissions')
@section('content')
<div class="card">
    <div class="card-header"><h5 class="mb-0">System Roles</h5></div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Role</th><th>Permissions</th><th></th></tr></thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions_count }} permissions</td>
                    <td class="text-end"><a href="{{ route('admin.roles.edit',$role) }}" class="btn btn-sm btn-outline-primary">Manage Permissions</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
