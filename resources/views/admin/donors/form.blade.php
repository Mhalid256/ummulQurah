@extends('layouts.admin')
@section('title', $donor->exists ? 'Edit Donor' : 'Register Donor')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $donor->exists ? route('admin.donors.update', $donor) : route('admin.donors.store') }}">
            @csrf
            @if($donor->exists) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Donor Type</label>
                    <select name="type" class="form-select" required>
                        <option value="individual" @selected(old('type', $donor->type)==='individual')>Individual</option>
                        <option value="organization" @selected(old('type', $donor->type)==='organization')>Organization</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $donor->first_name) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $donor->last_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Organization Name (if applicable)</label>
                    <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name', $donor->organization_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $donor->email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $donor->phone) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $donor->country) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', $donor->status ?? 'active')==='active')>Active</option>
                        <option value="inactive" @selected(old('status', $donor->status)==='inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $donor->address) }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input" @checked(old('is_recurring', $donor->is_recurring))>
                        <label class="form-check-label">Recurring donor</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $donor->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Save Donor</button>
                <a href="{{ route('admin.donors.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
