@extends('layouts.admin')
@section('title', $beneficiary->exists ? 'Edit Beneficiary' : 'Register Beneficiary')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $beneficiary->exists ? route('admin.beneficiaries.update',$beneficiary) : route('admin.beneficiaries.store') }}">
            @csrf
            @if($beneficiary->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name',$beneficiary->first_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name',$beneficiary->last_name) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', optional($beneficiary->dob)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">—</option>
                        @foreach(['male','female','other'] as $g)
                            <option value="{{ $g }}" @selected(old('gender',$beneficiary->gender)===$g)>{{ ucfirst($g) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        @foreach(['child','elderly','disabled','family','other'] as $c)
                            <option value="{{ $c }}" @selected(old('category',$beneficiary->category)===$c)>{{ ucfirst($c) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Family</label>
                    <select name="family_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($families as $family)
                            <option value="{{ $family->id }}" @selected(old('family_id',$beneficiary->family_id)==$family->id)>{{ $family->head_name }} ({{ $family->family_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Linked Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id',$beneficiary->project_id)==$project->id)>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$beneficiary->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location',$beneficiary->location) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address',$beneficiary->address) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Guardian Name</label>
                    <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name',$beneficiary->guardian_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Guardian Phone</label>
                    <input type="text" name="guardian_phone" class="form-control" value="{{ old('guardian_phone',$beneficiary->guardian_phone) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes',$beneficiary->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Save Beneficiary</button>
                <a href="{{ route('admin.beneficiaries.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
