<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('attendance:mark')->dailyAt('08:15'); //utc time not nepali time
Schedule::command('payroll:email')->monthlyOn(11, '08:15'); //2 pm nepali time
