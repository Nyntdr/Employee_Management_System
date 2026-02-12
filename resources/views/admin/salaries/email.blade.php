<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip Available</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c5282;
            padding-bottom: 20px;
        }
        .company-name {
            color: #2c5282;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .download-button {
            display: inline-block;
            background-color: #2c5282;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #718096;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <div class="company-name">N:Company</div>
        <div class="email-title">Your Payslip is Available</div>
    </div>

    <div class="content">
        <div class="greeting">
            Dear <strong>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</strong>,
        </div>

        <p>Your payslip for <strong>{{ $payroll->month_year->format('F Y') }}</strong> is now ready.</p>

        <p><strong>Payment Status:</strong> {{ ucfirst($payroll->payment_status->value) }}</p>

        @if($payroll->paid_date)
            <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($payroll->paid_date)->format('d M Y') }}</p>
        @endif

        <p><strong>Net Salary:</strong> NPR {{ number_format($payroll->net_salary, 2) }}</p>
        <p>For more information about your pay please download your payslip.</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $downloadLink }}" class="download-button" target="_blank">Download Your Payslip PDF</a>
        </div>
        <p>If you have any questions about your payslip, please contact the HR department.</p>
    </div>
</div>
</body>
</html>
