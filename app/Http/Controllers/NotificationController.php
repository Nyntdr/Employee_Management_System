<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function handle($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if (!$notification) {
            return redirect()->back();
        }
        $notification->markAsRead();

        if ($notification->type === 'App\Notifications\LeaveRequestNotification') {
            return redirect()->route('leaves.index');
        }
        if ($notification->type === 'App\Notifications\AssetRequestNotification') {
            return redirect()->route('assets.index');
        }
        if ($notification->type === 'App\Notifications\NoticeCreatedNotification') {
            if (in_array(auth()->user()->role_id, [1, 2])) {
                return redirect()->route('notices.index');
            }

            return redirect()->route('employee.notices.index');
        }
        if ($notification->type === 'App\Notifications\EventCreatedNotification') {
            if (in_array(auth()->user()->role_id, [1, 2])) {
                return redirect()->route('events.index');
            }

            return redirect()->route('employee.events.index');
        }
        return redirect()->back();
    }
}
