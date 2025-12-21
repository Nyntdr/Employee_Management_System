<?php

namespace App\Http\Controllers;

use App\Exports\NoticesExport;
use App\Models\Notice;
use App\Http\Requests\NoticeRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::paginate(5);
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }
    public function export()
    {
        return Excel::download(new NoticesExport(), 'notices_export.xlsx');
    }
    public function store(NoticeRequest $request)
    {
        // dd($request->all(),$request->ip());
        Notice::create(array_merge($request->validated(),['posted_by' => Auth::id()]));
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

        return redirect()->route('notices.index')->with('success', 'Notice updated successfully!');
    }

    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();
        return redirect()->route('notices.index')->with('success', 'Notice deleted successfully!');
    }
}
