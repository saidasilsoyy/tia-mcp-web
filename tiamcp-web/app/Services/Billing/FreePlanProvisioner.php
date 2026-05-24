<?php

namespace App\Services\Billing;

use App\Enums\EntitlementCode;
use App\Enums\PlanCode;
use App\Models\Entitlement;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

class FreePlanProvisioner
{
    public function provision(User $user): Subscription
    {
        $plan = $this->ensureFreePlan();

        return Subscription::firstOrCreate(
            [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'provider' => 'free',
            ],
            [
                'status' => 'active',
                'starts_at' => now(),
            ]
        );
    }

    public function ensureFreePlan(): Plan
    {
        $plan = Plan::updateOrCreate(
            ['code' => PlanCode::FreeBeta->value],
            [
                'name' => 'Free Beta',
                'status' => 'active',
                'price_cents' => 0,
                'currency' => 'USD',
                'billing_interval' => 'beta',
            ]
        );

        Plan::updateOrCreate(
            ['code' => PlanCode::ProPlaceholder->value],
            [
                'name' => 'Pro Placeholder',
                'status' => 'inactive',
                'price_cents' => 0,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
            ]
        );

        Plan::updateOrCreate(
            ['code' => PlanCode::TeamPlaceholder->value],
            [
                'name' => 'Team Placeholder',
                'status' => 'inactive',
                'price_cents' => 0,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
            ]
        );

        $entitlements = collect([
            EntitlementCode::McpBasic->value => ['MCP basic', 'Core MCP server access.'],
            EntitlementCode::TiaRead->value => ['TIA read', 'Read-only TIA automation tools.'],
            EntitlementCode::TiaWrite->value => ['TIA write', 'Write-capable TIA automation tools.'],
            EntitlementCode::GitLocal->value => ['Local Git', 'Local Git workflow tooling.'],
            EntitlementCode::GitHubConnected->value => ['GitHub connected', 'GitHub-backed product features when linked.'],
            EntitlementCode::AdvancedPolicy->value => ['Advanced policy', 'Advanced MCP policy controls.'],
            EntitlementCode::OfflineWindow->value => ['Offline window', 'Bounded signed offline entitlement.'],
            EntitlementCode::DesktopUpdates->value => ['Desktop updates', 'Desktop release and update access.'],
        ])->mapWithKeys(function (array $definition, string $code): array {
            $entitlement = Entitlement::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $definition[0],
                    'description' => $definition[1],
                ]
            );

            return [$code => $entitlement->id];
        });

        $plan->entitlements()->sync($entitlements->values()->all());

        return $plan;
    }
}
