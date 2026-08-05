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
        User::whereIn('email', [
            'fsilva.web@gmail.com',
            'demo@applyexpress.test',
            'empresa@applyexpress.test'
        ])->delete();
        Plan::whereIn('slug', ['free', 'pro', 'annual'])->delete();

        // Usuários de demonstração
        $adminUser = User::factory()->create([
            'name' => 'Felipe Silva',
            'email' => 'fsilva.web@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_SUPER_ADMIN,
            'is_admin' => true,
        ]);

        $candidatoUser = User::factory()->create([
            'name' => 'Usuário Demo',
            'email' => 'demo@applyexpress.test',
            'password' => Hash::make('demo123'),
            'role' => User::ROLE_CANDIDATO,
            'is_admin' => false,
        ]);

        $empresaUser = User::factory()->create([
            'name' => 'Empresa Demo',
            'email' => 'empresa@applyexpress.test',
            'password' => Hash::make('empresa123'),
            'role' => User::ROLE_EMPRESA,
            'is_admin' => false,
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

        // Assinatura ativa do usuário candidato no plano Pro
        $paymentService->subscribe($candidatoUser, $proPlan, 'sub_demo_123', 'demo');

        // Transação extra de créditos para demonstração
        CreditTransaction::create([
            'user_id' => $candidatoUser->id,
            'amount' => 25,
            'type' => 'add',
            'description' => 'Créditos bônus de boas-vindas',
        ]);
        $candidatoUser->increment('credits', 25);

        $this->command->info('Dados de demonstração criados com sucesso.');
        $this->command->info('Super Admin: fsilva.web@gmail.com / admin123');
        $this->command->info('Candidato: demo@applyexpress.test / demo123');
        $this->command->info('Empresa: empresa@applyexpress.test / empresa123');
    }
}
