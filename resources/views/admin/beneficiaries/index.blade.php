@extends('layouts.admin')
@section('title', 'Beneficiary Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Beneficiaries</h5>
        <a href="{{ route('admin.beneficiaries.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Register Beneficiary</a>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    @foreach(['pending','approved','rejected','inactive'] as $s)
                        <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach(['child','elderly','disabled','family','other'] as $c)
                        <option value="{{ $c }}" @selected(request('category')===$c)>{{ ucfirst($c) }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Ben. #</th><th>Name</th><th>Category</th><th>Family</th><th>Location</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($beneficiaries as $b)
                <tr>
                    <td>{{ $b->beneficiary_no }}</td>
                    <td>{{ $b->full_name }}</td>
                    <td><span class="badge bg-label-secondary">{{ ucfirst($b->category) }}</span></td>
                    <td>{{ $b->family->head_name ?? '—' }}</td>
                    <td>{{ $b->location }}</td>
                    <td><span class="badge bg-label-{{ $b->status==='approved'?'success':($b->status==='pending'?'warning':'danger') }}">{{ ucfirst($b->status) }}</span></td>
                    <td class="text-end">
                        @if($b->status === 'pending')
                            <form action="{{ route('admin.beneficiaries.approve',$b) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-sm btn-icon text-success" title="Approve"><i class="bx bx-check-circle"></i></button>
                            </form>
                            <form action="{{ route('admin.beneficiaries.reject',$b) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-sm btn-icon text-danger" title="Reject"><i class="bx bx-x-circle"></i></button>
                            </form>
                        @endif
                        <a href="{{ route('admin.beneficiaries.edit',$b) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.beneficiaries.destroy',$b) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this beneficiary?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No beneficiaries registered yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $beneficiaries->links() }}</div>
</div>
@endsection
