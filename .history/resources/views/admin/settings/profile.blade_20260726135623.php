@extends('layouts.admin')
@section('title', 'My Profile')
@section('content')
<ul class="nav nav-pills mb-4">
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.notifications') }}">Notifications</a></li>
    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.profile') }}">My Profile</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('two-factor.show') }}">Two-Factor Security</a></li>
</ul>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.settings.profile.update') }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required></div>
            <div class="col-md-6"><label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}"></div>
            <div class="col-md-6"><label class="form-label">New Password (optional)</label>
                <input type="password" name="password" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control"></div>
        </div>
        <div class="mt-4"><button class="btn btn-primary">Save Profile</button></div>
    </form>
</div></div>
@endsection
