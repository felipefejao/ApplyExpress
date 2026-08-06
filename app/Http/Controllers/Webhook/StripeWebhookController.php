<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
    ) {
    }

    public function __invoke(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('payment.gateways.stripe.webhook_secret');

        if (empty($secret)) {
            try {
                $this->handleEvent($request->all());
            } catch (\Throwable $exception) {
                report($exception);
                return response('Webhook inválido.', 400);
            }

            return response('Evento processado.', 200);
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException|\Stripe\Exception\SignatureVerificationException $exception) {
            report($exception);
            return response('Webhook inválido.', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            try {
                $this->paymentService->fulfillCheckoutSession($session->id);
            } catch (\Throwable $exception) {
                report($exception);
                return response('Erro ao processar checkout.', 500);
            }
        }

        return response('Evento recebido.', 200);
    }

    private function handleEvent(array $data): void
    {
        $type = $data['type'] ?? null;
        $session = $data['data']['object'] ?? null;

        if ($type === 'checkout.session.completed' && ! empty($session['id'])) {
            $this->paymentService->fulfillCheckoutSession($session['id']);
        }
    }
}
