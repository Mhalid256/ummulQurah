@extends('layouts.admin')
@section('title', $event->exists ? 'Edit Event' : 'New Event')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $event->exists ? route('admin.events.update',$event) : route('admin.events.store') }}">
        @csrf @if($event->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title',$event->title) }}" required></div>
            <div class="col-md-4"><label class="form-label">Type</label>
                <select name="type" class="form-select">
                    @foreach(['fundraiser','training','distribution','meeting','other'] as $t)
                        <option value="{{ $t }}" @selected(old('type',$event->type ?? 'other')===$t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-6"><label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location',$event->location) }}"></div>
            <div class="col-md-6"><label class="form-label">Linked Project</label>
                <select name="project_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($projects as $p)<option value="{{ $p->id }}" @selected(old('project_id',$event->project_id)==$p->id)>{{ $p->name }}</option>@endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Start</label>
                <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at', optional($event->start_at)->format('Y-m-d\TH:i')) }}" required></div>
            <div class="col-md-4"><label class="form-label">End</label>
                <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at', optional($event->end_at)->format('Y-m-d\TH:i')) }}"></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['planned','ongoing','completed','cancelled'] as $s)
                        <option value="{{ $s }}" @selected(old('status',$event->status ?? 'planned')===$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select></div>
            <div class="col-12"><label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description',$event->description) }}</textarea></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Event</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
