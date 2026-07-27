@extends('layouts.admin')
@section('title', 'Donation Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Donations</h5>
        <a href="{{ route('admin.donations.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Record Donation</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Receipt</th><th>Donor</th><th>Campaign</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($donations as $donation)
                <tr>
                    <td>{{ $donation->receipt_no }}</td>
                    <td>{{ $donation->donor->display_name ?? '-' }}</td>
                    <td>{{ $donation->campaign->title ?? '—' }}</td>
                    <td>{{ number_format($donation->amount, 2) }} {{ $donation->currency }}</td>
                    <td>{{ str_replace('_',' ', ucfirst($donation->payment_method)) }}</td>
                    <td>{{ $donation->donation_date->format('d M Y') }}</td>
                    <td><span class="badge bg-label-{{ $donation->status === 'completed' ? 'success' : ($donation->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($donation->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.donations.edit', $donation) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this donation?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No donations recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $donations->links() }}</div>
</div>
@endsection
