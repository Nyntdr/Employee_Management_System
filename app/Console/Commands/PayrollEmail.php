<?php

namespace App\Console\Commands;

use App\Mail\PayslipMail;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PayrollEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payroll:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to employee about their salary';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $month=Carbon::now()->subMonth()->format('Y-m');
        $payrolls=Payroll::with(['employee.user','employee.latestContract'])
            ->where('month_year',$month)
            ->where('payment_status','paid')
            ->get();

        if($payrolls->isEmpty())
        {
            $this->info('No salary payments have been made');
            return;
        }

        foreach($payrolls as $payroll)
        {
            $downloadLink=route('payrolls.payslip', $payroll);
            Mail::to($payroll->employee->user->email)->send(new PayslipMail($payroll, $downloadLink));
        }

        $this->info('Payslip emails sent successfully for ' . $month);
    }
}
