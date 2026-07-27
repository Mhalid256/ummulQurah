@extends('layouts.admin')
@section('title', 'Notification Preferences')
@section('content')
<ul class="nav nav-pills mb-4">
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.notifications') }}">Notifications</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.profile') }}">My Profile</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('two-factor.show') }}">Two-Factor Security</a></li>
</ul>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.settings.notifications.update') }}">
        @csrf @method('PUT')
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="notify_email" value="1" @checked($channels['notify_email'])>
            <label class="form-check-label">Email notifications</label>
        </div>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="notify_sms" value="1" @checked($channels['notify_sms'])>
            <label class="form-check-label">SMS notifications</label>
        </div>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="notify_whatsapp" value="1" @checked($channels['notify_whatsapp'])>
            <label class="form-check-label">WhatsApp notifications</label>
        </div>
        <div class="alert alert-info">These toggles control which channels the Communication module is allowed to use once real providers are connected.</div>
        <button class="btn btn-primary">Save Preferences</button>
    </form>
</div></div>
@endsection
