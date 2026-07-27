@extends('layouts.admin')
@section('title', 'Beneficiary Report')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Beneficiaries by Category &amp; Status</h5></div>
    <div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>Category</th><th>Status</th><th>Total</th></tr></thead>
        <tbody>
        @forelse ($summary as $row)
            <tr><td>{{ ucfirst($row->category) }}</td><td>{{ ucfirst($row->status) }}</td><td>{{ $row->total }}</td></tr>
        @empty
            <tr><td colspan="3" class="text-center text-muted py-4">No beneficiary data yet.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection
