<?php

namespace App\Enums;

enum AssetTypes: string
{
    case ELECTRONIC = 'electronic';
    case FURNITURE = 'furniture';
    case VEHICLE = 'vehicle';
    case STATIONERY = 'stationery';
    case OTHER = 'other';
}