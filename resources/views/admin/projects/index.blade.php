@extends('layouts.admin')
@section('title', 'Project Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Projects</h5>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> New Project</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Name</th><th>Sector</th><th>Manager</th><th>Budget</th><th>Dates</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($projects as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->sector }}</td>
                    <td>{{ $p->manager->name ?? '—' }}</td>
                    <td>{{ number_format($p->budget_amount,0) }}</td>
                    <td><small>{{ optional($p->start_date)->format('d M Y') }} - {{ optional($p->end_date)->format('d M Y') }}</small></td>
                    <td><span class="badge bg-label-{{ $p->status==='active'?'success':($p->status==='planned'?'secondary':'info') }}">{{ ucfirst($p->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.projects.edit',$p) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.projects.destroy',$p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No projects yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $projects->links() }}</div>
</div>
@endsection
