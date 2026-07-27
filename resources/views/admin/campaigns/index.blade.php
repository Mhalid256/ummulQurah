@extends('layouts.admin')
@section('title', 'Campaign Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Campaigns</h5>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> New Campaign</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Title</th><th>Goal</th><th>Raised</th><th>Progress</th><th>Dates</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->title }}<br><small class="text-muted">{{ $campaign->category }}</small></td>
                    <td>{{ number_format($campaign->goal_amount, 0) }} {{ $campaign->currency }}</td>
                    <td>{{ number_format($campaign->raised_amount, 0) }} {{ $campaign->currency }}</td>
                    <td style="min-width:120px">
                        <div class="progress" style="height:6px;"><div class="progress-bar" style="width:{{ $campaign->progress_percent }}%"></div></div>
                        <small>{{ $campaign->progress_percent }}%</small>
                    </td>
                    <td><small>{{ optional($campaign->start_date)->format('d M Y') }} - {{ optional($campaign->end_date)->format('d M Y') }}</small></td>
                    <td><span class="badge bg-label-{{ $campaign->status === 'active' ? 'success' : ($campaign->status === 'draft' ? 'secondary' : 'info') }}">{{ ucfirst($campaign->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('public.campaign.show', $campaign) }}" target="_blank" class="btn btn-sm btn-icon"><i class="bx bx-link-external"></i></a>
                        <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this campaign?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No campaigns yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $campaigns->links() }}</div>
</div>
@endsection
