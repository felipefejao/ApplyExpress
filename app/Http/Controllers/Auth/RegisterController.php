<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
    ) {
    }

    public function show()
    {
        $plans = Plan::query()
            ->where('is_active', true)
            ->whereNotNull('gateway_id')
            ->orderBy('price')
            ->get();

        return view('auth.register', compact('plans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_CANDIDATO,
            'credits' => 0,
        ]);

        try {
            $checkoutUrl = $this->paymentService->createCheckoutSession($user, $plan);
        } catch (\Throwable $exception) {
            $user->delete();

            return back()
                ->withInput()
                ->withErrors(['payment' => 'Não foi possível iniciar o pagamento: '.$exception->getMessage()]);
        }

        return redirect()->away($checkoutUrl);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (empty($sessionId) || $sessionId === '{CHECKOUT_SESSION_ID}') {
            return redirect()->route('register.index')->withErrors(['payment' => 'Sessão de pagamento inválida.']);
        }

        try {
            $this->paymentService->fulfillCheckoutSession($sessionId);
        } catch (\Throwable $exception) {
            return redirect()->route('register.index')->withErrors(['payment' => 'Não foi possível ativar sua assinatura: '.$exception->getMessage()]);
        }

        return view('auth.register-success', [
            'loginUrl' => route('filament.admin.auth.login'),
        ]);
    }

    public function cancel()
    {
        return view('auth.register-cancel');
    }
}
