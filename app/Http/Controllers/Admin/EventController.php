<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Project;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('project')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('start_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event(), 'projects' => Project::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['organizer_id'] = auth()->id();

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', ['event' => $event, 'projects' => Project::orderBy('name')->get()]);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->validated($request));
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:fundraiser,training,distribution,meeting,other',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:planned,ongoing,completed,cancelled',
        ]);
    }
}
