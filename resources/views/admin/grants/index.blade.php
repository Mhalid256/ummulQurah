@extends('layouts.admin')
@section('title', 'Grant Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Grants</h5>
        <a href="{{ route('admin.grants.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> New Grant</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Title</th><th>Funder</th><th>Project</th><th>Amount</th><th>Reporting Due</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($grants as $g)
                <tr>
                    <td>{{ $g->title }}</td>
                    <td>{{ $g->funder_name }}</td>
                    <td>{{ $g->project->name ?? '—' }}</td>
                    <td>{{ number_format($g->amount,2) }} {{ $g->currency }}</td>
                    <td>{{ optional($g->reporting_due_date)->format('d M Y') ?? '—' }}</td>
                    <td><span class="badge bg-label-{{ in_array($g->status,['awarded','active'])?'success':($g->status==='applied'?'warning':'secondary') }}">{{ ucfirst($g->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.grants.edit',$g) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.grants.destroy',$g) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this grant?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No grants yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $grants->links() }}</div>
</div>
@endsection
