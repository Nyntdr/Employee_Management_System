<?php

namespace App\Enums;

enum JobTitle: string
{
    case ADMINISTRATOR = 'administrator';
    case HUMAN_RESOURCE = 'human_resource';
    case RECEPTIONIST = 'receptionist';
    case INTERN = 'intern';
    case MANAGER = 'manager';
    case ACCOUNTANT = 'accountant';
    case SALES_EXECUTIVE = 'sales_executive';
    case MARKETING_MANAGER = 'marketing_manager';
    case IT_SUPPORT = 'it_support';
    case DEVELOPER = 'developer';
    case TEAM_LEADER = 'team_leader';
    case FINANCE_MANAGER = 'finance_manager';
    case OPERATIONS_MANAGER = 'operations_manager';
    case HR_ASSISTANT = 'hr_assistant';
    case OFFICE_ASSISTANT = 'office_assistant';
    case SUPERVISOR = 'supervisor';
}