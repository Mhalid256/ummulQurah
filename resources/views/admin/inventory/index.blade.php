@extends('layouts.admin')
@section('title', 'Inventory')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Inventory Items</h5>
        <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> New Item</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>SKU</th><th>Name</th><th>Category</th><th>Qty on Hand</th><th>Reorder Level</th><th>Unit Cost</th><th></th></tr></thead>
            <tbody>
            @forelse ($items as $item)
                <tr class="{{ $item->is_low_stock ? 'table-warning' : '' }}">
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ number_format($item->quantity_on_hand,2) }} {{ $item->unit }}</td>
                    <td>{{ number_format($item->reorder_level,2) }}</td>
                    <td>{{ number_format($item->unit_cost,2) }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.inventory.transactions',$item) }}" class="btn btn-sm btn-icon" title="Stock movements"><i class="bx bx-transfer"></i></a>
                        <a href="{{ route('admin.inventory.edit',$item) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.inventory.destroy',$item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No inventory items yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
</div>
@endsection
