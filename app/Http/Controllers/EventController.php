<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }
    public function create()
    {
        return view('admin.events.create'); 
    }
   public function store(EventRequest $request)
{
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        Event::create($validated);
        return redirect()->route('events.index');
}
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }
public function update(EventRequest $request, string $id)
{
    $event = Event::findOrFail($id);
    $validated = $request->validated();
    unset($validated['created_by']);
    $event->update($validated);
    return redirect()->route('events.index');
}
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index');   
    }
}
