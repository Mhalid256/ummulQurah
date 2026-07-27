@extends('layouts.admin')
@section('title', 'Expenses')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Expenses</h5>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Submit Expense</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Description</th><th>Category</th><th>Budget</th><th>Amount</th><th>Date</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($expenses as $e)
                <tr>
                    <td>{{ $e->description }}</td>
                    <td>{{ $e->category }}</td>
                    <td>{{ $e->budget->title ?? '—' }}</td>
                    <td>{{ number_format($e->amount,2) }}</td>
                    <td>{{ $e->expense_date->format('d M Y') }}</td>
                    <td><span class="badge bg-label-{{ $e->status==='approved'?'success':($e->status==='pending'?'warning':'danger') }}">{{ ucfirst($e->status) }}</span></td>
                    <td class="text-end">
                        @if($e->status === 'pending')
                            <form action="{{ route('admin.expenses.approve',$e) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-icon text-success"><i class="bx bx-check-circle"></i></button></form>
                            <form action="{{ route('admin.expenses.reject',$e) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-x-circle"></i></button></form>
                        @endif
                        <form action="{{ route('admin.expenses.destroy',$e) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this expense?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No expenses recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $expenses->links() }}</div>
</div>
@endsection
