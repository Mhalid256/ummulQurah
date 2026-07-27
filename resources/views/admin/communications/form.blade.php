@extends('layouts.admin')
@section('title', 'Compose Message')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.communications.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Channel</label>
                <select name="channel" class="form-select" required>
                    <option value="email">Email</option>
                    <option value="sms">SMS</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="in_app">In-App Notification</option>
                </select></div>
            <div class="col-md-6"><label class="form-label">Audience</label>
                <select name="audience" class="form-select" required>
                    <option value="all_donors">All Active Donors</option>
                    <option value="all_sponsors">All Recurring Sponsors</option>
                    <option value="all_volunteers">All Active Volunteers</option>
                    <option value="all_staff">All Staff</option>
                </select></div>
            <div class="col-12"><label class="form-label">Message</label>
                <textarea name="body" class="form-control" rows="5" required></textarea></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Send Message</button>
            <a href="{{ route('admin.communications.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
