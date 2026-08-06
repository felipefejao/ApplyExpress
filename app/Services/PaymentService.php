<?php

namespace App\Services;

use App\Models\CreditTransaction;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class PaymentService
{
    public function getActiveGateway(): string
    {
        $gateway = config('payment.default_gateway');

        if (! config("payment.gateways.{$gateway}.enabled")) {
            throw new \RuntimeException("Gateway de pagamento {$gateway} não está habilitado.");
        }

        return $gateway;
    }

    public function subscribe(User $user, Plan $plan, string $gatewaySubscriptionId = null, string $gateway = null): Subscription
    {
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'gateway' => $gateway ?? $this->getActiveGateway(),
            'gateway_subscription_id' => $gatewaySubscriptionId,
            'status' => 'active',
            'starts_at' => now(),
        ]);

        Log::info($subscription);

        if ($plan->credits_included > 0) {
            $this->addCredits($user, $plan->credits_included, 'add', "Créditos inclusos no plano {$plan->name}");
        }

        return $subscription;
    }

    public function addCredits(User $user, int $amount, string $type = 'add', ?string $description = null, ?string $referenceType = null, ?int $referenceId = null): CreditTransaction
    {
        CreditTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => $type,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);

        $user->increment('credits', $amount);

        return CreditTransaction::latest('id')->first();
    }

    public function deductCredits(User $user, int $amount, ?string $description = null, ?string $referenceType = null, ?int $referenceId = null): ?CreditTransaction
    {
        if ($user->credits < $amount) {
            throw new \RuntimeException('Créditos insuficientes.');
        }

        $transaction = CreditTransaction::create([
            'user_id' => $user->id,
            'amount' => -$amount,
            'type' => 'deduct',
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);

        $user->decrement('credits', $amount);

        return $transaction;
    }

    public function getStripeClient(): StripeClient
    {
        $secret = config('payment.gateways.stripe.secret_key');

        if (empty($secret)) {
            throw new \RuntimeException('Chave secreta do Stripe não configurada.');
        }

        return new StripeClient($secret);
    }

    public function getStripeMode(Plan $plan): string
    {
        return in_array($plan->interval, ['month', 'year']) ? 'subscription' : 'payment';
    }

    public function createCheckoutSession(User $user, Plan $plan): string
    {
        if (! config('payment.gateways.stripe.enabled')) {
            throw new \RuntimeException('Gateway Stripe não está habilitado.');
        }

        $gatewayId = $plan->gateway_id;

        if (empty($gatewayId)) {
            throw new \RuntimeException('Plano não possui gateway_id do Stripe configurado.');
        }

        $client = $this->getStripeClient();

        $lineItem = $this->buildPriceDataLineItem($plan, $gatewayId);

        $session = $client->checkout->sessions->create([
            'customer_email' => $user->email,
            'line_items' => [$lineItem],
            'mode' => $this->getStripeMode($plan),
            'success_url' => route('register.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('register.cancel'),
            'metadata' => [
                'user_id' => (string) $user->id,
                'plan_id' => (string) $plan->id,
            ],
        ]);

        return $session->url;
    }

    private function buildPriceDataLineItem(Plan $plan, string $productId): array
    {
        $priceData = [
            'product' => $productId,
            'currency' => strtolower($plan->currency ?? 'brl'),
            'unit_amount' => (int) round($plan->price * 100),
        ];

        if ($this->getStripeMode($plan) === 'subscription') {
            $priceData['recurring'] = ['interval' => $plan->interval];
        }

        return [
            'price_data' => $priceData,
            'quantity' => 1,
        ];
    }

    public function fulfillCheckoutSession(string $sessionId): Subscription
    {
        if (! config('payment.gateways.stripe.enabled')) {
            throw new \RuntimeException('Gateway Stripe não está habilitado.');
        }

        $client = $this->getStripeClient();
        $session = $client->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            throw new \RuntimeException('Pagamento ainda não foi confirmado.');
        }

        $existing = Subscription::where('gateway_subscription_id', $session->id)->first();

        if ($existing) {
            return $existing;
        }

        $userId = $session->metadata['user_id'] ?? null;
        $planId = $session->metadata['plan_id'] ?? null;

        if (! $userId || ! $planId) {
            throw new \RuntimeException('Sessão de checkout não possui metadados de usuário ou plano.');
        }

        $user = User::findOrFail($userId);
        $plan = Plan::findOrFail($planId);

        $gatewaySubscriptionId = $session->subscription ?? $session->id;

        return $this->subscribe($user, $plan, $gatewaySubscriptionId, 'stripe');
    }

    public function cancelSubscription(Subscription $subscription): Subscription
    {
        $subscription->update([
            'status' => 'canceled',
            'canceled_at' => now(),
            'ends_at' => $subscription->ends_at ?? now()->addDays(30),
        ]);

        return $subscription;
    }
}
