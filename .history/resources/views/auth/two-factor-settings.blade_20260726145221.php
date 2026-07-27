@extends('layouts.admin')
@section('title', 'Two-Factor Authentication')
@section('content')
<ul class="nav nav-pills mb-4">
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.notifications') }}">Notifications</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.profile') }}">My Profile</a></li>
    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.two-factor.show') }}">Two-Factor Security</a></li>
</ul>

<div class="card"><div class="card-body">
    @if ($user->hasTwoFactorEnabled())
        <div class="alert alert-success"><i class="bx bx-check-shield me-2"></i>Two-factor authentication is <strong>enabled</strong> on your account.</div>
        <form method="POST" action="{{ route('admin.two-factor.disable') }}" onsubmit="return confirm('Disable two-factor authentication?');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger">Disable Two-Factor Authentication</button>
        </form>
    @else
        <h5>Enable Two-Factor Authentication</h5>
        <p class="text-muted">Scan this QR code with Google Authenticator, Authy, or any TOTP app, then enter the 6-digit code below to confirm.</p>
        <div class="mb-3">{!! $qrCodeUrl !!}</div>

        @if ($errors->any())
            <div class="alert alert-danger">@foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach</div>
        @endif

        <form method="POST" action="{{ route('admin.two-factor.confirm') }}" class="row g-2" style="max-width:400px;">
            @csrf
            <div class="col-8"><input type="text" name="code" class="form-control" placeholder="6-digit code" maxlength="6" required></div>
            <div class="col-4"><button class="btn btn-primary w-100">Confirm &amp; Enable</button></div>
        </form>
    @endif

    @if (session('recovery_codes'))
        <div class="alert alert-warning mt-4">
            <strong>Save these recovery codes somewhere safe</strong> &mdash; each can be used once if you lose access to your authenticator app:
            <ul class="mt-2">
                @foreach (session('recovery_codes') as $code)
                    <li><code>{{ $code }}</code></li>
                @endforeach
            </ul>
        </div>
    @endif
</div></div>
@endsection