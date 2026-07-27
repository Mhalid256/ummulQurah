@extends('layouts.admin')
@section('title', 'Campaign / Impact Report')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Campaigns Ranked by Funds Raised</h5></div>
    <div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>Title</th><th>Raised</th><th>Goal</th><th>Progress</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($campaigns as $c)
            <tr>
                <td>{{ $c->title }}</td>
                <td>{{ number_format($c->raised_amount,2) }}</td>
                <td>{{ number_format($c->goal_amount,2) }}</td>
                <td>{{ $c->progress_percent }}%</td>
                <td>{{ ucfirst($c->status) }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No campaign data yet.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection
