@extends('layouts.admin')
@section('title', $volunteer->exists ? 'Edit Volunteer' : 'Register Volunteer')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $volunteer->exists ? route('admin.volunteers.update',$volunteer) : route('admin.volunteers.store') }}">
        @csrf @if($volunteer->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name',$volunteer->first_name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name',$volunteer->last_name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email',$volunteer->email) }}"></div>
            <div class="col-md-6"><label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$volunteer->phone) }}"></div>
            <div class="col-md-6"><label class="form-label">Skills</label>
                <input type="text" name="skills" class="form-control" value="{{ old('skills',$volunteer->skills) }}" placeholder="e.g. First Aid, Teaching, Driving"></div>
            <div class="col-md-6"><label class="form-label">Availability</label>
                <select name="availability" class="form-select">
                    @foreach(['weekdays','weekends','evenings','flexible'] as $a)
                        <option value="{{ $a }}" @selected(old('availability',$volunteer->availability ?? 'flexible')===$a)>{{ ucfirst($a) }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Assigned Project</label>
                <select name="project_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($projects as $p)<option value="{{ $p->id }}" @selected(old('project_id',$volunteer->project_id)==$p->id)>{{ $p->name }}</option>@endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Coordinator</label>
                <select name="coordinator_id" class="form-select">
                    <option value="">— Unassigned —</option>
                    @foreach($coordinators as $c)<option value="{{ $c->id }}" @selected(old('coordinator_id',$volunteer->coordinator_id)==$c->id)>{{ $c->name }}</option>@endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['pending','active','inactive'] as $s)<option value="{{ $s }}" @selected(old('status',$volunteer->status ?? 'pending')===$s)>{{ ucfirst($s) }}</option>@endforeach
                </select></div>
            <div class="col-12"><label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes',$volunteer->notes) }}</textarea></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Volunteer</button>
            <a href="{{ route('admin.volunteers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
