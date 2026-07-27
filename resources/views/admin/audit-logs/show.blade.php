@extends('layouts.admin')
@section('title', 'Audit Log Detail')

@section('content')
<style>
    .diff-table td { vertical-align: top; }
    .diff-old { background-color: #fde2e1; text-decoration: line-through; color: #7a1f1d; }
    .diff-new { background-color: #d1f7e0; color: #0f6d3c; }
    .diff-unchanged { color: #6c757d; }
    .raw-json {
        background: #1e1e2f; color: #d4d4d4; padding: 1rem; border-radius: .5rem;
        font-family: 'Courier New', monospace; font-size: .85rem; max-height: 400px; overflow: auto; display: none;
    }
</style>

<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3"><strong>When</strong><br>{{ $auditLog->created_at->format('d M Y, H:i:s') }}</div>
            <div class="col-md-3"><strong>User</strong><br>{{ $auditLog->user->name ?? 'System' }}</div>
            <div class="col-md-2"><strong>Action</strong><br>{{ ucfirst($auditLog->action) }}</div>
            <div class="col-md-2"><strong>Model</strong><br>{{ class_basename($auditLog->auditable_type) }} #{{ $auditLog->auditable_id }}</div>
            <div class="col-md-2"><strong>IP Address</strong><br>{{ $auditLog->ip_address ?? '—' }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Field Changes</h5>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleRawJson()">Toggle Raw JSON</button>
    </div>
    <div class="card-body">
        @php
            $old = $auditLog->old_values ?? [];
            $new = $auditLog->new_values ?? [];
            $keys = collect(array_keys($old))->merge(array_keys($new))->unique()->sort()->values();
        @endphp

        @if ($keys->isEmpty())
            <p class="text-muted mb-0">No field-level data was recorded for this event.</p>
        @else
            <table class="table diff-table">
                <thead><tr><th>Field</th><th>Before</th><th>After</th></tr></thead>
                <tbody>
                @foreach ($keys as $key)
                    @php
                        $oldVal = $old[$key] ?? null;
                        $newVal = $new[$key] ?? null;
                        $changed = $oldVal !== $newVal;
                    @endphp
                    <tr>
                        <td><code>{{ $key }}</code></td>
                        <td class="{{ $changed && $auditLog->action !== 'created' ? 'diff-old' : 'diff-unchanged' }}">
                            {{ is_array($oldVal) ? json_encode($oldVal) : ($oldVal ?? '—') }}
                        </td>
                        <td class="{{ $changed ? 'diff-new' : 'diff-unchanged' }}">
                            {{ is_array($newVal) ? json_encode($newVal) : ($newVal ?? '—') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <pre id="rawJson" class="raw-json">{{ json_encode(['old' => $old, 'new' => $new], JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary">Back to Audit Logs</a>
</div>

<script>
    function toggleRawJson() {
        var el = document.getElementById('rawJson');
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }
</script>
@endsection