<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use App\Enums\AttendanceStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AttendanceMarker extends Command
{
    protected $signature = 'attendance:mark';
    protected $description = 'Automatically mark absent employees who did not clock in';

    public function handle() : void
    {
        $today = Carbon::today();

        $employees = Employee::whereHas('latestContract', function ($query) {
            $query->whereIn('contract_status', ['active', 'renewed']);
        })->get();

        foreach ($employees as $employee) {

            $exists = Attendance::where('employee_id', $employee->employee_id)
                ->whereDate('date', $today)
                ->exists();

            if ($exists) {
                continue;
            }

            Attendance::create([
                'employee_id' => $employee->employee_id,
                'date'        => $today,
                'clock_in'    => null,
                'clock_out'   => null,
                'total_hours' => null,
                'status'      => AttendanceStatus::ABSENT->value,
            ]);
        }
        Cache::flush();
        $this->info('Absent employees marked successfully.');
    }
}
