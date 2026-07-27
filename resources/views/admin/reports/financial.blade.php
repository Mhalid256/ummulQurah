@extends('layouts.admin')
@section('title', 'Financial Report')
@section('content')
<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-2">
        <div class="col-md-3"><input type="date" name="from" class="form-control" value="{{ request('from', $from->format('Y-m-d')) }}"></div>
        <div class="col-md-3"><input type="date" name="to" class="form-control" value="{{ request('to', $to->format('Y-m-d')) }}"></div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
    </form>
</div>
<div class="row g-4">
    <div class="col-md-4"><div class="card"><div class="card-body"><span class="text-muted">Total Donations</span><h3>{{ number_format($donations,2) }}</h3></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><span class="text-muted">Total Approved Expenses</span><h3>{{ number_format($expenses,2) }}</h3></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><span class="text-muted">Net</span><h3 class="{{ ($donations-$expenses)<0?'text-danger':'text-success' }}">{{ number_format($donations-$expenses,2) }}</h3></div></div></div>
</div>
<div class="card mt-4"><div class="card-header"><h5 class="mb-0">Donations by Payment Method</h5></div>
    <div class="table-responsive"><table class="table">
        <thead><tr><th>Method</th><th>Total</th></tr></thead>
        <tbody>
        @foreach ($byMethod as $row)
            <tr><td>{{ str_replace('_',' ',ucfirst($row->payment_method)) }}</td><td>{{ number_format($row->total,2) }}</td></tr>
        @endforeach
        </tbody>
    </table></div>
</div>
@endsection
