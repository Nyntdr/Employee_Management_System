<?php

namespace App\Http\Controllers;

use App\Exports\EventsExport;
use App\Imports\EventImport;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EventCreatedNotification;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'events_index_' . md5($search . '_page_' . $page);
        $events = Cache::remember(
            $cacheKey,
            now()->addMinutes(2),
            function () use ($search) {
                return Event::query()->with('creator')
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['title',], 'like', "%{$search}%")
                            ->orWhereHas('creator', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereDate('event_date', 'like', "%{$search}%");
                    })->paginate(5);
            }
        );
        if ($request->ajax()) {
            return view('admin.events.table', compact('events'))->render();
        }

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function export()
    {
        return Excel::download(new EventsExport(), 'event_export.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new EventImport, $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Events imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        $event = Event::create($validated);
        Cache::flush();
        $users = User::whereNot('id', auth()->id())->get();
        Notification::send($users, new EventCreatedNotification($event));
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
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
        Cache::flush();
        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        Cache::flush();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
}
