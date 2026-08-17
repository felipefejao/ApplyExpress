<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use DatabaseTransactions;

    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = app(PaymentService::class);
    }

    public function test_user_can_subscribe_to_a_plan_and_receive_credits(): void
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create([
            'name' => 'Pro',
            'slug' => 'pro',
            'credits_included' => 50,
        ]);

        $subscription = $this->paymentService->subscribe($user, $plan, 'sub_123', 'demo');

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('credit_transactions', [
            'user_id' => $user->id,
            'amount' => 50,
            'type' => 'add',
        ]);

        $this->assertEquals(50, $user->fresh()->credits);
    }

    public function test_credits_can_be_deducted(): void
    {
        $user = User::factory()->create(['credits' => 100]);

        $this->paymentService->deductCredits($user, 30, 'Envio de candidatura');

        $this->assertEquals(70, $user->fresh()->credits);
        $this->assertDatabaseHas('credit_transactions', [
            'user_id' => $user->id,
            'amount' => -30,
            'type' => 'deduct',
        ]);
    }

    public function test_deducting_more_credits_than_available_throws_exception(): void
    {
        $user = User::factory()->create(['credits' => 10]);

        $this->expectException(\RuntimeException::class);

        $this->paymentService->deductCredits($user, 20);
    }

    public function test_subscription_can_be_canceled(): void
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create();
        $subscription = $this->paymentService->subscribe($user, $plan, null, 'demo');

        $this->paymentService->cancelSubscription($subscription);

        $this->assertEquals('canceled', $subscription->fresh()->status);
        $this->assertNotNull($subscription->fresh()->canceled_at);
    }
}
