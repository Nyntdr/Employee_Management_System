<?php

namespace App\Enums;

enum AssetStatuses: string
{
    case REQUESTED = 'requested';
    case AVAILABLE = 'available';
    case ASSIGNED = 'assigned';
    case UNDER_REPAIR = 'under_repair';
}
