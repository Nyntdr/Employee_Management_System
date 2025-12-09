<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notices.index', compact('notices'));
    }
    public function create()
    {
        return view('admin.notices.create'); 
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
        ]);

        Notice::create([
            'title'       => $request->title,
            'content'     => $request->input('content'),
            'posted_by'   => Auth::id(),               
            'published_at'=> now(),                   
            'created_at'  => now(),
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice published successfully!');
    }
    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }
    public function update(Request $request, string $id)
    {
        $notice = Notice::findOrFail($id);
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
        ]);
        $notice->update([
            'title'       => $request->title,
            'content'     => $request->input('content'),

        ]);
        return redirect()->route('notices.index');
    }
    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();
        return redirect()->route('notices.index');   
    }
}
