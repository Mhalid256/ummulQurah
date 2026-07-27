@extends('layouts.admin')
@section('title', 'Budgets')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Budgets</h5>
        <a href="{{ route('admin.budgets.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> New Budget Line</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Title</th><th>Project</th><th>Fiscal Year</th><th>Allocated</th><th>Spent</th><th>Remaining</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($budgets as $b)
                <tr>
                    <td>{{ $b->title }}</td>
                    <td>{{ $b->project->name ?? '—' }}</td>
                    <td>{{ $b->fiscal_year }}</td>
                    <td>{{ number_format($b->amount_allocated,2) }}</td>
                    <td>{{ number_format($b->amount_spent,2) }}</td>
                    <td class="{{ $b->remaining < 0 ? 'text-danger' : '' }}">{{ number_format($b->remaining,2) }}</td>
                    <td><span class="badge bg-label-{{ $b->status==='approved'?'success':($b->status==='draft'?'secondary':'info') }}">{{ ucfirst($b->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.budgets.edit',$b) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.budgets.destroy',$b) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this budget?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No budget lines yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $budgets->links() }}</div>
</div>
@endsection
