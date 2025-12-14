<?php
namespace App\Enums;

enum JobTitle: string
{
    case ADMINISTRATOR = 'administrator';
    case HUMAN_RESOURCE = 'human_resource';
    case RECEPTIONIST = 'receptionist';
    case INTERN = 'intern';
}