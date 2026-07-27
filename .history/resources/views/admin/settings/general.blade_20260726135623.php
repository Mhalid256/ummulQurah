@extends('layouts.admin')
@section('title', 'Organization Settings')
@section('content')
<ul class="nav nav-pills mb-4">
    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.general') }}">General</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.notifications') }}">Notifications</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.profile') }}">My Profile</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('two-factor.show') }}">Two-Factor Security</a></li>
</ul>
<div class="card"><div class="card-body">
    @if(!$organization)
        <div class="alert alert-warning">Only organization accounts have organization settings. Super Administrators manage this per-organization.</div>
    @else
    <form method="POST" action="{{ route('admin.settings.general.update') }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Organization Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$organization->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email',$organization->email) }}"></div>
            <div class="col-md-4"><label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$organization->phone) }}"></div>
            <div class="col-md-4"><label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" value="{{ old('country',$organization->country) }}"></div>
            <div class="col-md-4"><label class="form-label">Currency</label>
                <input type="text" name="currency" class="form-control" value="{{ old('currency',$organization->currency) }}" required></div>
            <div class="col-12"><label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address',$organization->address) }}</textarea></div>
        </div>
        <div class="mt-4"><button class="btn btn-primary">Save Changes</button></div>
    </form>
    @endif
</div></div>
@endsection
