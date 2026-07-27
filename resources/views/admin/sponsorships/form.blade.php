@extends('layouts.admin')
@section('title', $sponsorship->exists ? 'Edit Sponsorship' : 'Assign Sponsor')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $sponsorship->exists ? route('admin.sponsorships.update',$sponsorship) : route('admin.sponsorships.store') }}">
            @csrf
            @if($sponsorship->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Sponsor (Donor)</label>
                    <select name="sponsor_id" class="form-select" required>
                        <option value="">Select donor</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}" @selected(old('sponsor_id',$sponsorship->sponsor_id)==$donor->id)>{{ $donor->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Beneficiary</label>
                    <select name="beneficiary_id" class="form-select" required>
                        <option value="">Select beneficiary</option>
                        @foreach($beneficiaries as $b)
                            <option value="{{ $b->id }}" @selected(old('beneficiary_id',$sponsorship->beneficiary_id)==$b->id)>{{ $b->full_name }} ({{ $b->beneficiary_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount',$sponsorship->amount) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Currency</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency',$sponsorship->currency ?? 'USD') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Frequency</label>
                    <select name="frequency" class="form-select">
                        @foreach(['one_off','monthly','quarterly','annual'] as $f)
                            <option value="{{ $f }}" @selected(old('frequency',$sponsorship->frequency ?? 'monthly')===$f)>{{ ucfirst(str_replace('_',' ',$f)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['active','paused','ended'] as $s)
                            <option value="{{ $s }}" @selected(old('status',$sponsorship->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($sponsorship->start_date)->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($sponsorship->end_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes',$sponsorship->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Save Sponsorship</button>
                <a href="{{ route('admin.sponsorships.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
