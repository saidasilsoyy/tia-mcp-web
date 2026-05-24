<?php

namespace App\Services\Billing;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionService
{
    public function __construct(private readonly FreePlanProvisioner $freePlanProvisioner) {}

    public function ensureLaunchSubscription(User $user): Subscription
    {
        return $this->freePlanProvisioner->provision($user);
    }
}
