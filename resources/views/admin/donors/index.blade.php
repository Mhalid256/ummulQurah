@extends('layouts.admin')
@section('title', 'Donor Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Donors</h5>
        <a href="{{ route('admin.donors.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add Donor</a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, org or email">
            </div>
            <div class="col-md-2"><button class="btn btn-outline-primary w-100">Search</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Donor #</th><th>Name</th><th>Type</th><th>Contact</th><th>Total Donated</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($donors as $donor)
                <tr>
                    <td>{{ $donor->donor_no }}</td>
                    <td>{{ $donor->display_name }}</td>
                    <td><span class="badge bg-label-secondary">{{ ucfirst($donor->type) }}</span></td>
                    <td>{{ $donor->email }}<br><small class="text-muted">{{ $donor->phone }}</small></td>
                    <td>{{ number_format($donor->total_donated, 2) }}</td>
                    <td><span class="badge bg-label-{{ $donor->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($donor->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.donors.edit', $donor) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.donors.destroy', $donor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this donor?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No donors registered yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $donors->links() }}</div>
</div>
@endsection
