@extends('layouts.admin')
@section('title', $budget->exists ? 'Edit Budget' : 'New Budget Line')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $budget->exists ? route('admin.budgets.update',$budget) : route('admin.budgets.store') }}">
        @csrf @if($budget->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title',$budget->title) }}" required></div>
            <div class="col-md-6"><label class="form-label">Project</label>
                <select name="project_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($projects as $p)<option value="{{ $p->id }}" @selected(old('project_id',$budget->project_id)==$p->id)>{{ $p->name }}</option>@endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category',$budget->category) }}"></div>
            <div class="col-md-4"><label class="form-label">Amount Allocated</label>
                <input type="number" step="0.01" name="amount_allocated" class="form-control" value="{{ old('amount_allocated',$budget->amount_allocated) }}" required></div>
            <div class="col-md-4"><label class="form-label">Fiscal Year</label>
                <input type="text" name="fiscal_year" class="form-control" value="{{ old('fiscal_year',$budget->fiscal_year ?? date('Y')) }}" required></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['draft','approved','closed'] as $s)<option value="{{ $s }}" @selected(old('status',$budget->status ?? 'draft')===$s)>{{ ucfirst($s) }}</option>@endforeach
                </select></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Budget</button>
            <a href="{{ route('admin.budgets.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
