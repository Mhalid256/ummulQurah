@extends('layouts.admin')
@section('title', 'Document Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Documents</h5>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-upload"></i> Upload Document</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Title</th><th>Category</th><th>Type</th><th>Size</th><th>Uploaded By</th><th></th></tr></thead>
            <tbody>
            @forelse ($documents as $doc)
                <tr>
                    <td>{{ $doc->title }}</td>
                    <td><span class="badge bg-label-secondary">{{ $doc->category ?? 'Uncategorized' }}</span></td>
                    <td>{{ strtoupper($doc->file_type) }}</td>
                    <td>{{ number_format(($doc->file_size ?? 0)/1024, 1) }} KB</td>
                    <td>{{ $doc->uploadedBy->name ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn btn-sm btn-icon"><i class="bx bx-download"></i></a>
                        <form action="{{ route('admin.documents.destroy',$doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this document?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No documents uploaded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $documents->links() }}</div>
</div>
@endsection
