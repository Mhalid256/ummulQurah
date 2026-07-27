@extends('layouts.admin')
@section('title', 'Upload Document')
@section('content')
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" placeholder="Policy, Report, Contract..."></div>
            <div class="col-12"><label class="form-label">File</label>
                <input type="file" name="file" class="form-control" required></div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Upload</button>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
