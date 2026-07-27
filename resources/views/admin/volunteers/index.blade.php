@extends('layouts.admin')
@section('title', 'Volunteer Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Volunteers</h5>
        <a href="{{ route('admin.volunteers.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Register Volunteer</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Vol. #</th><th>Name</th><th>Contact</th><th>Availability</th><th>Project</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($volunteers as $v)
                <tr>
                    <td>{{ $v->volunteer_no }}</td>
                    <td>{{ $v->full_name }}</td>
                    <td>{{ $v->email }}<br><small class="text-muted">{{ $v->phone }}</small></td>
                    <td>{{ ucfirst($v->availability) }}</td>
                    <td>{{ $v->project->name ?? '—' }}</td>
                    <td><span class="badge bg-label-{{ $v->status==='active'?'success':($v->status==='pending'?'warning':'secondary') }}">{{ ucfirst($v->status) }}</span></td>
                    <td class="text-end">
                        @if($v->status === 'pending')
                            <form action="{{ route('admin.volunteers.approve',$v) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-sm btn-icon text-success" title="Approve"><i class="bx bx-check-circle"></i></button>
                            </form>
                        @endif
                        <a href="{{ route('admin.volunteers.edit',$v) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.volunteers.destroy',$v) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this volunteer?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No volunteers registered yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $volunteers->links() }}</div>
</div>
@endsection
