<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
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
   public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:200',
        'description' => 'nullable|string',
        'event_date'  => 'required|date',
        'start_time'  => 'nullable|date_format:H:i',
        'end_time'    => 'nullable|date_format:H:i|after:start_time',
    ]);

    Event::create([
        'title'       => $request->title,
        'description' => $request->description,
        'event_date'  => $request->event_date,
        'start_time'  => $request->start_time,
        'end_time'    => $request->end_time,
        'created_by'  => Auth::id(),
    ]);

    return redirect()->route('events.index')->with('success', 'Event created successfully!');
}
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }
public function update(Request $request, string $id)
{
    $event = Event::findOrFail($id);
    $request->validate([
        'title'       => 'required|string|max:200',
        'description' => 'nullable|string',
        'event_date'  => 'required|date',
        'start_time'  => 'nullable|date_format:H:i',
        'end_time'    => 'nullable|date_format:H:i|after:start_time',
    ]);

    $event->update([
        'title'       => $request->title,
        'description' => $request->description,
        'event_date'  => $request->event_date,
        'start_time'  => $request->start_time,
        'end_time'    => $request->end_time,
    ]);

    return redirect()->route('events.index')->with('success', 'Event updated successfully!');
}
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index');   
    }
}
