@extends('layouts.admin')
@section('title', $grant->exists ? 'Edit Grant' : 'New Grant')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $grant->exists ? route('admin.grants.update',$grant) : route('admin.grants.store') }}">
        @csrf @if($grant->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Grant Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title',$grant->title) }}" required></div>
            <div class="col-md-6"><label class="form-label">Funder Name</label>
                <input type="text" name="funder_name" class="form-control" value="{{ old('funder_name',$grant->funder_name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Project</label>
                <select name="project_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($projects as $p)<option value="{{ $p->id }}" @selected(old('project_id',$grant->project_id)==$p->id)>{{ $p->name }}</option>@endforeach
                </select></div>
            <div class="col-md-3"><label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount',$grant->amount) }}" required></div>
            <div class="col-md-3"><label class="form-label">Currency</label>
                <input type="text" name="currency" class="form-control" value="{{ old('currency',$grant->currency ?? 'USD') }}" required></div>
            <div class="col-md-3"><label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($grant->start_date)->format('Y-m-d')) }}"></div>
            <div class="col-md-3"><label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($grant->end_date)->format('Y-m-d')) }}"></div>
            <div class="col-md-3"><label class="form-label">Reporting Due Date</label>
                <input type="date" name="reporting_due_date" class="form-control" value="{{ old('reporting_due_date', optional($grant->reporting_due_date)->format('Y-m-d')) }}"></div>
            <div class="col-md-3"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['applied','awarded','active','closed','declined'] as $s)<option value="{{ $s }}" @selected(old('status',$grant->status ?? 'applied')===$s)>{{ ucfirst($s) }}</option>@endforeach
                </select></div>
            <div class="col-md-6"><label class="form-label">Contact Person</label>
                <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person',$grant->contact_person) }}"></div>
            <div class="col-12"><label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes',$grant->notes) }}</textarea></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Grant</button>
            <a href="{{ route('admin.grants.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
