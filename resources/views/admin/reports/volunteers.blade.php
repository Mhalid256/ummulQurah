@extends('layouts.admin')
@section('title', 'Volunteer Report')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Volunteers by Status</h5></div>
    <div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>Status</th><th>Total</th></tr></thead>
        <tbody>
        @forelse ($summary as $row)
            <tr><td>{{ ucfirst($row->status) }}</td><td>{{ $row->total }}</td></tr>
        @empty
            <tr><td colspan="2" class="text-center text-muted py-4">No volunteer data yet.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection
