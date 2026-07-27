@extends('layouts.admin')
@section('title', 'Family Records')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Families</h5>
        <a href="{{ route('admin.families.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Register Family</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Code</th><th>Head of Family</th><th>Members</th><th>Beneficiaries</th><th>Location</th><th>Income Level</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($families as $f)
                <tr>
                    <td>{{ $f->family_code }}</td>
                    <td>{{ $f->head_name }}</td>
                    <td>{{ $f->members_count }}</td>
                    <td>{{ $f->beneficiaries_count }}</td>
                    <td>{{ $f->location }}</td>
                    <td><span class="badge bg-label-secondary">{{ str_replace('_',' ',ucfirst($f->income_level)) }}</span></td>
                    <td><span class="badge bg-label-{{ $f->status==='active'?'success':'secondary' }}">{{ ucfirst($f->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.families.edit',$f) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.families.destroy',$f) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this family record?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No family records yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $families->links() }}</div>
</div>
@endsection
