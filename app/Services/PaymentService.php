<?php

namespace App\Services;

use App\Models\CreditTransaction;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

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
