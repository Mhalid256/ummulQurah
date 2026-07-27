<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::with('uploadedBy')
            ->when($request->category, fn ($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'category' => $request->category,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return back()->with('success', 'Document removed.');
    }
}
