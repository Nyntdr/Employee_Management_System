<?php

namespace App\Notifications;

use App\Http\Requests\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LeaveRequestNotification extends Notification
{
    use Queueable;
    protected $leave_request;
    public function __construct($leave_request)
    {
        $this->leave_request = $leave_request;
    }
    public function via($notifiable): array
    {
        return ['database'];
    }
    public function toDatabase($notifiable): array
    {
        return [
            'leave_type' => $this->leave_request->leaveType->name,
            'employee_id' => $this->leave_request->employee->employee_id,
            'employee_name' => $this->leave_request->employee->employee_first_name . ' ' . $this->leave_request->employee->employee_last_name,
            'start_date' => $this->leave_request->start_date,
            'end_date' => $this->leave_request->end_date,
            'reason' => $this->leave_request->reason,
            'status' => 'pending',
            'message' => $this->leave_request->employee->first_name . ' ' . $this->leave_request->employee->last_name . ' has requested for a leave. ',
        ];
    }
}
