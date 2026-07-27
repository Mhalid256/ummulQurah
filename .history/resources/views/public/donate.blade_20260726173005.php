@extends('layouts.public')
@section('title', 'Donate to ' . $campaign->title)
@section('content')
<div class="container-fluid py-5">
    <div class="container" style="max-width:600px;">
        <h2 class="mb-4">Donate to: {{ $campaign->title }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('public.donate.submit', $campaign) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone (optional)</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Amount ({{ $campaign->currency }})</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-select" required>
                    <option value="mobile_money">Mobile Money</option>
                    <option value="card">Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <div class="form-text">Payment gateway integration is coming in a later phase &mdash; your pledge will be recorded as pending until then.</div>
            </div>
            <button class="btn btn-primary rounded-pill w-100 py-2">Confirm Donation</button>
        </form>
    </div>
</div>
@endsection
