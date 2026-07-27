@extends('layouts.admin')
@section('title', 'Audit Logs')

@section('content')
<style>
    .audit-badge-created { background-color: #d1f7e0; color: #0f6d3c; }
    .audit-badge-updated { background-color: #fff3cd; color: #8a6500; }
    .audit-badge-deleted { background-color: #fde2e1; color: #9c2b28; }
    .audit-badge-approved, .audit-badge-login { background-color: #dbe9ff; color: #1f4faa; }
    .audit-badge {
        display: inline-block; padding: 2px 10px; border-radius: 999px;
        font-size: .75rem; font-weight: 600; text-transform: capitalize;
    }
    .audit-filter-bar { display: flex; flex-wrap: wrap; gap: .5rem; align-items: end; }
    .audit-filter-bar > div { min-width: 160px; }
</style>

<div class="card">
    <div class="card-header">
        <h5 class="mb-3">Audit Logs</h5>
        <form method="GET" class="audit-filter-bar">
            <div>
                <label class="form-label small mb-1">Model</label>
                <select name="model" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Models</option>
                    @foreach ($models as $model)
                        <option value="{{ $model }}" @selected(request('model') === $model)>{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label small mb-1">Action</label>
                <select name="action" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Actions</option>
                    @foreach (['created','updated','deleted'] as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label small mb-1">From</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
            </div>
            <div>
                <label class="form-label small mb-1">To</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
            </div>
            <div>
                <button class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>When</th><th>User</th><th>Action</th><th>Model</th><th>Record #</th><th>IP</th><th></th></tr></thead>
            <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td><small>{{ $log->created_at->format('d M Y, H:i:s') }}</small></td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td><span class="audit-badge audit-badge-{{ $log->action }}">{{ $log->action }}</span></td>
                    <td>{{ class_basename($log->auditable_type) }}</td>
                    <td>#{{ $log->auditable_id }}</td>
                    <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                    <td class="text-end">
                        <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-icon" title="View details"><i class="bx bx-show"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No audit activity recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $logs->links() }}</div>
</div>
@endsection