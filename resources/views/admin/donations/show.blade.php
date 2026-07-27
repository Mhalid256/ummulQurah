@extends('layouts.admin')
@section('title', 'Donation Receipt')
@section('content')
<div class="card">
    <div class="card-body">
        <h5>Receipt #{{ $donation->receipt_no }}</h5>
        <dl class="row mt-3">
            <dt class="col-sm-3">Donor</dt><dd class="col-sm-9">{{ $donation->donor->display_name }}</dd>
            <dt class="col-sm-3">Campaign</dt><dd class="col-sm-9">{{ $donation->campaign->title ?? 'General Fund' }}</dd>
            <dt class="col-sm-3">Amount</dt><dd class="col-sm-9">{{ number_format($donation->amount,2) }} {{ $donation->currency }}</dd>
            <dt class="col-sm-3">Method</dt><dd class="col-sm-9">{{ str_replace('_',' ',ucfirst($donation->payment_method)) }}</dd>
            <dt class="col-sm-3">Date</dt><dd class="col-sm-9">{{ $donation->donation_date->format('d M Y') }}</dd>
            <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ ucfirst($donation->status) }}</dd>
            <dt class="col-sm-3">Received By</dt><dd class="col-sm-9">{{ $donation->receiver->name ?? '—' }}</dd>
        </dl>
        <a href="{{ route('admin.donations.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
@endsection
