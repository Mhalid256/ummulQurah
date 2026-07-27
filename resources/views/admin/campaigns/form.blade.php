@extends('layouts.admin')
@section('title', $campaign->exists ? 'Edit Campaign' : 'New Campaign')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $campaign->exists ? route('admin.campaigns.update', $campaign) : route('admin.campaigns.store') }}" enctype="multipart/form-data">
            @csrf
            @if($campaign->exists) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $campaign->title) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $campaign->category) }}" placeholder="e.g. Education, Health">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Linked Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id', $campaign->project_id)==$project->id)>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Goal Amount</label>
                    <input type="number" step="0.01" name="goal_amount" class="form-control" value="{{ old('goal_amount', $campaign->goal_amount) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Currency</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency', $campaign->currency ?? 'USD') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($campaign->start_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($campaign->end_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['draft','active','completed','cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $campaign->status ?? 'draft')===$status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Summary</label>
                    <textarea name="summary" class="form-control" rows="2">{{ old('summary', $campaign->summary) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Full Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $campaign->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control">
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Save Campaign</button>
                <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
