@extends('layouts.admin')
@section('title', $project->exists ? 'Edit Project' : 'New Project')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $project->exists ? route('admin.projects.update',$project) : route('admin.projects.store') }}">
            @csrf
            @if($project->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Project Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$project->name) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sector</label>
                    <input type="text" name="sector" class="form-control" value="{{ old('sector',$project->sector) }}" placeholder="Education, Health, WASH...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Manager</label>
                    <select name="manager_id" class="form-select">
                        <option value="">— Unassigned —</option>
                        @foreach($managers as $m)
                            <option value="{{ $m->id }}" @selected(old('manager_id',$project->manager_id)==$m->id)>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Budget Amount</label>
                    <input type="number" step="0.01" name="budget_amount" class="form-control" value="{{ old('budget_amount',$project->budget_amount) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($project->end_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['planned','active','completed','suspended'] as $s)
                            <option value="{{ $s }}" @selected(old('status',$project->status ?? 'planned')===$s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description',$project->description) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Save Project</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
