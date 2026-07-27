@extends('layouts.admin')
@section('title', 'Donor Report')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Top 50 Donors by Lifetime Giving</h5></div>
    <div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>#</th><th>Donor</th><th>Type</th><th>Total Donated</th></tr></thead>
        <tbody>
        @forelse ($donors as $i => $donor)
            <tr><td>{{ $i+1 }}</td><td>{{ $donor->display_name }}</td><td>{{ ucfirst($donor->type) }}</td><td>{{ number_format($donor->total_donated,2) }}</td></tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No donor data yet.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection
