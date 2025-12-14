<?php

namespace App\Enums;

enum AttendanceStatus:string
{
    case PRESENT = 'present';
    case LATE = 'late';
    case ABSENT = 'absent';
    case HALF_DAY = 'half day';
    case LEAVE = 'leave';
    case HOLIDAY = 'holiday';
}
