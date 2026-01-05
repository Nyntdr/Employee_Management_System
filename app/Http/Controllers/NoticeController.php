<?php

namespace App\Http\Controllers;

use App\Exports\NoticesExport;
use App\Imports\NoticesImport;
use App\Models\Notice;
use App\Http\Requests\NoticeRequest;
use App\Models\User;
use App\Notifications\NoticeCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
//      $notices = Notice::latest()->paginate(5);
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'contracts_index_' . md5($search . '_page_' . $page);

        $notices = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return Notice::query()->with('poster')
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['title', 'content'], 'like', "%{$search}%")
                            ->orWhereHas('poster', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->latest()->paginate(5);
            }
        );
        if ($request->ajax()) {
            return view('admin.notices.table', compact('notices'))->render();
        }
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new NoticesImport(), $request->file('file'));
        return back()->with('success', 'All good!');
    }

    public function export()
    {
        return Excel::download(new NoticesExport(), 'notices_export.xlsx');
    }

    public function store(NoticeRequest $request)
    {
        // dd($request->all(),$request->ip());
        $notice = Notice::create(array_merge($request->validated(), ['posted_by' => Auth::id()]));
        Cache::flush();
        $users = User::whereNot('id', auth()->id())->get();
        Notification::send($users, new NoticeCreatedNotification($notice));
        return redirect()->route('notices.index')->with('success', 'Notice published successfully!');
    }

    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(NoticeRequest $request, string $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->update($request->validated());
        Cache::flush();
        return redirect()->route('notices.index')->with('success', 'Notice updated successfully!');
    }

    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();
        return redirect()->route('notices.index')->with('success', 'Notice deleted successfully!');
    }
}
