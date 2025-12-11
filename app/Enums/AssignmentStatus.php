<?php

namespace App\Enums;

enum AssignmentStatus: string
{
    case ACTIVE = 'active';
    case RETURNED = 'returned';
    case LOST = 'lost';
    case DAMAGED = 'damaged';
}