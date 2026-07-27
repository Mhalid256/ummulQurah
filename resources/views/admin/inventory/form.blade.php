@extends('layouts.admin')
@section('title', $item->exists ? 'Edit Inventory Item' : 'New Inventory Item')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ $item->exists ? route('admin.inventory.update',$item) : route('admin.inventory.store') }}">
        @csrf @if($item->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku',$item->sku) }}" placeholder="Auto-generated if blank"></div>
            <div class="col-md-8"><label class="form-label">Item Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$item->name) }}" required></div>
            <div class="col-md-4"><label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category',$item->category) }}"></div>
            <div class="col-md-4"><label class="form-label">Unit</label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit',$item->unit ?? 'pcs') }}" required></div>
            <div class="col-md-4"><label class="form-label">Warehouse/Location</label>
                <input type="text" name="warehouse" class="form-control" value="{{ old('warehouse',$item->warehouse) }}"></div>
            <div class="col-md-4"><label class="form-label">Reorder Level</label>
                <input type="number" step="0.01" name="reorder_level" class="form-control" value="{{ old('reorder_level',$item->reorder_level ?? 0) }}" required></div>
            <div class="col-md-4"><label class="form-label">Unit Cost</label>
                <input type="number" step="0.01" name="unit_cost" class="form-control" value="{{ old('unit_cost',$item->unit_cost ?? 0) }}" required></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected(old('status',$item->status ?? 'active')==='active')>Active</option>
                    <option value="discontinued" @selected(old('status',$item->status)==='discontinued')>Discontinued</option>
                </select></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Item</button>
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
