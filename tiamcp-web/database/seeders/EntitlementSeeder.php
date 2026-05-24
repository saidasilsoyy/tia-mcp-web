<?php

namespace Database\Seeders;

use App\Services\Billing\FreePlanProvisioner;
use Illuminate\Database\Seeder;

class EntitlementSeeder extends Seeder
{
    public function run(): void
    {
        app(FreePlanProvisioner::class)->ensureFreePlan();
    }
}
