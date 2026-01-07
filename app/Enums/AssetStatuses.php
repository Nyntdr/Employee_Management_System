<?php

namespace App\Enums;

enum AssetStatuses: string
{
    case AVAILABLE = 'available';
    case ASSIGNED = 'assigned';
    case UNDER_REPAIR = 'under_repair';
    case DISPOSED = 'disposed';
    case LOST = 'lost';
}