@extends('layouts.admin')
@section('title', 'Events')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Events</h5>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> New Event</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Title</th><th>Type</th><th>Location</th><th>Start</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($events as $e)
                <tr>
                    <td>{{ $e->title }}</td>
                    <td><span class="badge bg-label-secondary">{{ ucfirst($e->type) }}</span></td>
                    <td>{{ $e->location }}</td>
                    <td>{{ $e->start_at->format('d M Y, H:i') }}</td>
                    <td><span class="badge bg-label-{{ $e->status==='completed'?'success':($e->status==='cancelled'?'danger':'info') }}">{{ ucfirst($e->status) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.events.edit',$e) }}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>
                        <form action="{{ route('admin.events.destroy',$e) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No events scheduled yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $events->links() }}</div>
</div>
@endsection
