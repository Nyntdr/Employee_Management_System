<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Event;
use App\Models\Leave;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function assetIndex()
    {
        $assets = Asset::where('asset_id', Auth::id())->get();
        return view('employee.assets.index', compact('assets'));
    }
        public function eventIndex()
    {
        $events=Event::all();
        return view('employee.events.index', compact('events'));
    }
        public function noticeIndex()
    {
        $notices=Notice::all();
        return view('employee.notices.index', compact('notices'));
    }
            public function leaveIndex()
    {
        $leaves=Leave::all();
        return view('employee.leaves.index', compact('leaves'));
    }
    
}
