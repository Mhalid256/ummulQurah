@extends('layouts.admin')
@section('title', $family->exists ? 'Edit Family' : 'Register Family')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $family->exists ? route('admin.families.update',$family) : route('admin.families.store') }}">
        @csrf @if($family->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Head of Family</label>
                <input type="text" name="head_name" class="form-control" value="{{ old('head_name',$family->head_name) }}" required></div>
            <div class="col-md-3"><label class="form-label">Members Count</label>
                <input type="number" min="1" name="members_count" class="form-control" value="{{ old('members_count',$family->members_count ?? 1) }}" required></div>
            <div class="col-md-3"><label class="form-label">Income Level</label>
                <select name="income_level" class="form-select">
                    @foreach(['very_low'=>'Very Low','low'=>'Low','moderate'=>'Moderate'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('income_level',$family->income_level ?? 'low')===$val)>{{ $label }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-6"><label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location',$family->location) }}"></div>
            <div class="col-md-3"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected(old('status',$family->status ?? 'active')==='active')>Active</option>
                    <option value="inactive" @selected(old('status',$family->status)==='inactive')>Inactive</option>
                </select></div>
            <div class="col-12"><label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address',$family->address) }}</textarea></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Family</button>
            <a href="{{ route('admin.families.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
