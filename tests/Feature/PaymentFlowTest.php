<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_registration_page_lists_active_plans(): void
    {
        Plan::factory()->create([
            'name' => 'Starter',
            'slug' => 'starter',
            'price' => 29.90,
            'gateway_id' => 'price_starter_test',
            'is_active' => true,
        ]);

        Plan::factory()->create([
            'name' => 'Elite',
            'slug' => 'elite',
            'price' => 99.90,
            'gateway_id' => null,
            'is_active' => true,
        ]);

        $response = $this->get(route('register.index'));

        $response->assertStatus(200);
        $response->assertSee('Starter');
        $response->assertSee('R$ 29,90');
        $response->assertDontSee('Elite');
    }

    public function test_user_can_register_and_is_redirected_to_stripe_checkout(): void
    {
        $plan = Plan::factory()->create([
            'name' => 'Profissional',
            'slug' => 'profissional',
            'price' => 59.90,
            'gateway_id' => 'price_profissional_test',
            'is_active' => true,
            'interval' => 'month',
            'credits_included' => 150,
        ]);

        $this->mock(PaymentService::class)
            ->shouldReceive('createCheckoutSession')
            ->once()
            ->andReturn('https://checkout.stripe.com/test-session');

        $response = $this->post(route('register.store'), [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'plan_id' => $plan->id,
        ]);

        $response->assertRedirect('https://checkout.stripe.com/test-session');

        $this->assertDatabaseHas('users', [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'role' => 'candidato',
        ]);
    }

    public function test_success_page_saves_subscription_and_shows_login_redirect(): void
    {
        $user = User::factory()->create(['email' => 'joao@example.com']);
        $plan = Plan::factory()->create(['credits_included' => 150]);

        $subscription = new Subscription([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'gateway' => 'stripe',
            'status' => 'active',
            'starts_at' => now(),
        ]);
        $subscription->save();

        $this->mock(PaymentService::class)
            ->shouldReceive('fulfillCheckoutSession')
            ->once()
            ->with('cs_test_123')
            ->andReturn($subscription);

        $response = $this->get(route('register.success', ['session_id' => 'cs_test_123']));

        $response->assertStatus(200);
        $response->assertSee('Pagamento confirmado!');
        $response->assertSee(route('filament.admin.auth.login'));
    }

    public function test_stripe_webhook_fulfills_checkout(): void
    {
        $subscription = Subscription::factory()->create();

        $this->mock(PaymentService::class)
            ->shouldReceive('fulfillCheckoutSession')
            ->once()
            ->with('cs_test_123')
            ->andReturn($subscription);

        config(['payment.gateways.stripe.webhook_secret' => '']);

        $response = $this->postJson(route('webhooks.stripe'), [
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_123',
                ],
            ],
        ]);

        $response->assertStatus(200);
    }

    public function test_registration_with_invalid_email_shows_errors(): void
    {
        $plan = Plan::factory()->create(['gateway_id' => 'price_test', 'is_active' => true]);

        $response = $this->post(route('register.store'), [
            'name' => 'João Silva',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'plan_id' => $plan->id,
        ]);

        $response->assertSessionHasErrors('email');
    }
}
