<?php

namespace Tests\Feature;

use App\Models\CreditTransaction;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentResourceAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_exist(): void
    {
        $routes = [
            '/admin',
            '/admin/login',
            '/admin/plans',
            '/admin/subscriptions',
            '/admin/credit-transactions',
            '/admin/profile',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 302, 403], true),
                "Route {$route} is not registered."
            );
        }
    }

    public function test_resources_are_persisted(): void
    {
        $plan = Plan::factory()->create();
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
        ]);
        $transaction = CreditTransaction::factory()->create([
            'user_id' => $user->id,
            'amount' => 100,
        ]);

        $this->assertModelExists($plan);
        $this->assertModelExists($subscription);
        $this->assertModelExists($transaction);
    }

    public function test_plan_has_subscriptions_relation(): void
    {
        $plan = Plan::factory()->create();
        $user = User::factory()->create();
        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
        ]);

        $this->assertCount(1, $plan->subscriptions);
    }
}
