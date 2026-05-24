<?php

namespace App\Enums;

enum PlanCode: string
{
    case FreeBeta = 'free_beta';
    case ProPlaceholder = 'pro_placeholder';
    case TeamPlaceholder = 'team_placeholder';
}
