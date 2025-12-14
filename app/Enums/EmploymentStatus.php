<?php

namespace App\Enums;

enum EmploymentStatus:string
{
    case ACTIVE = "active";
    case TERMINATED = "terminated";
    case ON_LEAVE = "on leave";
}
