@extends('layouts.admin')
@section('title', 'Sponsorship Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Sponsorships</h5>
        <a href="{{ route('admin.sponsorships.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Assign Sponsor</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Sponsor</th><th>Beneficiary</th><th>Amount</th><th>Frequency</th><th>Start</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($sponsorships as $s)
                <tr>
                    <td>{{ $s->sponsor->display_name ?? '-' }}</td>
                    <td>{{ $s->beneficiary->full_name ?? '-' }}</td>
                    <td>{{ number_format($s->amount,2) }} {{ $s->currency }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$s->frequency)) }}</td>
                    <td>{{ $s->start_date->format('d M Y') }}</td>
                    <td><span class="badge bg-label-{{ $s->status==='active'?'success':($s->status==='paused'?'warning':'secondary') }}">{{ ucfirst($s->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.sponsorships.edit',$s) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.sponsorships.destroy',$s) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sponsorship?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No sponsorships yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $sponsorships->links() }}</div>
</div>
@endsection
