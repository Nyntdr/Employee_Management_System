<?php

namespace App\Enums;

enum PayStatus:string
{
    case PENDING = "pending";
    case PAID = "paid";
    case FAILED = "failed";
}
