<?php

namespace Database\Seeders;

use App\Models\CreditTransaction;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $paymentService = app(PaymentService::class);

        // Limpa dados de demonstração anteriores
        User::where('email', 'demo@applyexpress.test')->delete();
        Plan::whereIn('slug', ['free', 'pro', 'annual'])->delete();

        // Usuário de demonstração
        $demoUser = User::factory()->create([
            'name' => 'Usuário Demo',
            'email' => 'demo@applyexpress.test',
            'password' => Hash::make('demo123'),
            'linkedin' => 'https://linkedin.com/in/demo',
            'github' => 'https://github.com/demo',
            'phone' => '+55 11 99999-9999',
            'bio' => 'Usuário de demonstração do ApplyExpress.',
            'locale' => 'pt_BR',
            'is_admin' => true,
        ]);

        // Planos de exemplo
        $freePlan = Plan::factory()->create([
            'name' => 'Gratuito',
            'slug' => 'free',
            'description' => 'Plano gratuito com funcionalidades básicas.',
            'price' => 0,
            'interval' => 'lifetime',
            'credits_included' => 5,
            'features' => [
                'envio_limitado' => true,
                'ia_basica' => true,
            ],
        ]);

        $proPlan = Plan::factory()->create([
            'name' => 'Pro',
            'slug' => 'pro',
            'description' => 'Plano mensal com envios ilimitados e IA avançada.',
            'price' => 29.90,
            'interval' => 'month',
            'credits_included' => 100,
            'features' => [
                'envios_ilimitados' => true,
                'ia_avancada' => true,
                'multiplos_perfis' => true,
            ],
        ]);

        $annualPlan = Plan::factory()->create([
            'name' => 'Anual',
            'slug' => 'annual',
            'description' => 'Plano anual com desconto.',
            'price' => 299.90,
            'interval' => 'year',
            'credits_included' => 1200,
            'features' => [
                'envios_ilimitados' => true,
                'ia_avancada' => true,
                'multiplos_perfis' => true,
            ],
        ]);

        // Assinatura ativa do usuário demo no plano Pro
        $paymentService->subscribe($demoUser, $proPlan, 'sub_demo_123', 'demo');

        // Transação extra de créditos para demonstração
        CreditTransaction::create([
            'user_id' => $demoUser->id,
            'amount' => 25,
            'type' => 'add',
            'description' => 'Créditos bônus de boas-vindas',
        ]);
        $demoUser->increment('credits', 25);

        $this->command->info('Dados de demonstração criados com sucesso.');
        $this->command->info('Login: demo@applyexpress.test / demo123');
    }
}
