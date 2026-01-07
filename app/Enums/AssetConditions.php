<?php

namespace App\Enums;

enum AssetConditions: string
{
    case NEW = 'new';
    case GOOD = 'good';
    case FAIR = 'fair';
    case POOR = 'poor';
    case DAMAGED = 'damaged';
}