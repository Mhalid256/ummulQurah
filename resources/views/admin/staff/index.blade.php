@extends('layouts.admin')
@section('title', 'Staff Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Staff Accounts</h5>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add Staff Member</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Name</th><th>Email</th><th>Roles</th><th>Status</th><th>Last Login</th><th></th></tr></thead>
            <tbody>
            @forelse ($staff as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-label-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td><span class="badge bg-label-{{ $user->status==='active'?'success':'secondary' }}">{{ ucfirst($user->status) }}</span></td>
                    <td><small>{{ optional($user->last_login_at)->diffForHumans() ?? 'Never' }}</small></td>
                    <td class="text-end">
                        <a href="{{ route('admin.staff.edit',$user) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.staff.destroy',$user) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this staff account?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No staff accounts yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $staff->links() }}</div>
</div>
@endsection
