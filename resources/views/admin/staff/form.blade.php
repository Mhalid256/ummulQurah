@extends('layouts.admin')
@section('title', $staffMember->exists ? 'Edit Staff Member' : 'Add Staff Member')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $staffMember->exists ? route('admin.staff.update',$staffMember) : route('admin.staff.store') }}">
        @csrf @if($staffMember->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$staffMember->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email',$staffMember->email) }}" required></div>
            <div class="col-md-6"><label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$staffMember->phone) }}"></div>
            <div class="col-md-6"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['active','inactive','suspended'] as $s)<option value="{{ $s }}" @selected(old('status',$staffMember->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>@endforeach
                </select></div>
            <div class="col-md-6"><label class="form-label">Password {{ $staffMember->exists ? '(leave blank to keep unchanged)' : '' }}</label>
                <input type="password" name="password" class="form-control" {{ $staffMember->exists ? '' : 'required' }}></div>
            <div class="col-12">
                <label class="form-label">Roles</label>
                <div class="row">
                    @foreach($roles as $role)
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role->name }}" id="role{{ $role->id }}"
                                    @checked($staffMember->exists && $staffMember->hasRole($role->name))>
                                <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Staff Member</button>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
