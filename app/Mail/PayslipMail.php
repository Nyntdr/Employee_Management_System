<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payroll;

class PayslipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payroll;
    public $downloadLink;

    public function __construct(Payroll $payroll, $downloadLink)
    {
        $this->payroll = $payroll;
        $this->downloadLink = $downloadLink;
    }

    public function build()
    {
        return $this->subject('Your Payslip for ' . $this->payroll->month_year->format('F Y'))
            ->view('admin.salaries.email');
    }
}
