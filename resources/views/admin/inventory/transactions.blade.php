@extends('layouts.admin')
@section('title', 'Stock Movements: ' . $item->name)
@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card"><div class="card-header"><h5 class="mb-0">Record Movement</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.inventory.transactions.store',$item) }}">
                    @csrf
                    <div class="mb-3"><label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="stock_in">Stock In</option>
                            <option value="stock_out">Stock Out</option>
                            <option value="adjustment">Adjustment</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label">Quantity</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Date</label>
                        <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                    <div class="mb-3"><label class="form-label">Reference</label>
                        <input type="text" name="reference" class="form-control" placeholder="PO#, distribution list, etc."></div>
                    <div class="mb-3"><label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea></div>
                    <button class="btn btn-primary w-100">Record</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card"><div class="card-header"><h5 class="mb-0">History for {{ $item->name }} (current: {{ number_format($item->quantity_on_hand,2) }} {{ $item->unit }})</h5></div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Date</th><th>Type</th><th>Qty</th><th>Reference</th><th>By</th></tr></thead>
                    <tbody>
                    @forelse ($transactions as $t)
                        <tr>
                            <td>{{ $t->transaction_date->format('d M Y') }}</td>
                            <td><span class="badge bg-label-{{ $t->type==='stock_in'?'success':($t->type==='stock_out'?'danger':'secondary') }}">{{ str_replace('_',' ',ucfirst($t->type)) }}</span></td>
                            <td>{{ number_format($t->quantity,2) }}</td>
                            <td>{{ $t->reference }}</td>
                            <td>{{ $t->recordedBy->name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No movements recorded yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body">{{ $transactions->links() }}</div>
        </div>
    </div>
</div>
@endsection
