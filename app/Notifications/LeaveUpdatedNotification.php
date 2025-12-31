<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeaveUpdatedNotification extends Notification
{
    use Queueable;

    protected $leave;

    public function __construct($leave)
    {
        $this->leave = $leave;
    }

    public function via($notifiable) : array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'leave_id' => $this->leave->leave_id,
            'status' => $this->leave->status->value,
            'start_date' => $this->leave->start_date,
            'end_date' => $this->leave->end_date,
            'employee_name' => $this->leave->employee->first_name,
            'leave_type' => $this->leave->leaveType->name,
            'reason' => $this->leave->reason,
            'approved_by' =>$this->leave->approver->name,
            'message' => "Your leave request ".$this->leave->leaveType->name." has been {$this->leave->status->value} by {$this->leave->approver->name}",
        ];
    }
}
