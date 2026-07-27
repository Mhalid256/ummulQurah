@extends('layouts.admin')
@section('title', 'Submit Expense')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.expenses.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Budget Line</label>
                <select name="budget_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($budgets as $b)<option value="{{ $b->id }}">{{ $b->title }}</option>@endforeach
                </select></div>
            <div class="col-md-6"><label class="form-label">Project</label>
                <select name="project_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($projects as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" required></div>
            <div class="col-md-8"><label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Expense Date</label>
                <input type="date" name="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required></div>
            <div class="col-md-4"><label class="form-label">Vendor</label>
                <input type="text" name="vendor" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Receipt (upload)</label>
                <input type="file" name="receipt_path" class="form-control"></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Submit Expense</button>
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
