@extends('layouts.admin')
@section('title', $donation->exists ? 'Edit Donation' : 'Record Donation')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $donation->exists ? route('admin.donations.update', $donation) : route('admin.donations.store') }}">
            @csrf
            @if($donation->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Donor</label>
                    <select name="donor_id" class="form-select" required>
                        <option value="">Select donor</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}" @selected(old('donor_id', $donation->donor_id)==$donor->id)>{{ $donor->display_name }} ({{ $donor->donor_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Campaign (optional)</label>
                    <select name="campaign_id" class="form-select">
                        <option value="">— General Fund —</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" @selected(old('campaign_id', $donation->campaign_id)==$campaign->id)>{{ $campaign->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $donation->amount) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Currency</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency', $donation->currency ?? 'USD') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        @foreach(['cash','bank_transfer','mobile_money','card','cheque','other'] as $method)
                            <option value="{{ $method }}" @selected(old('payment_method', $donation->payment_method ?? 'cash')===$method)>{{ str_replace('_',' ', ucfirst($method)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Donation Date</label>
                    <input type="date" name="donation_date" class="form-control" value="{{ old('donation_date', optional($donation->donation_date)->format('Y-m-d') ?? date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Transaction Reference</label>
                    <input type="text" name="transaction_ref" class="form-control" value="{{ old('transaction_ref', $donation->transaction_ref) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['pending','completed','failed','refunded'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $donation->status ?? 'completed')===$status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $donation->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Save Donation</button>
                <a href="{{ route('admin.donations.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
