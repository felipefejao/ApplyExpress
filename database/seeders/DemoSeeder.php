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
        Plan::whereIn('slug', ['starter', 'profissional', 'elite'])->delete();

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
        $starterPlan = Plan::factory()->create([
            'name' => 'Starter',
            'slug' => 'starter',
            'description' => 'Ideal para quem está começando a organizar as candidaturas.',
            'price' => 29.90,
            'interval' => 'month',
            'credits_included' => 50,
            'gateway_id' => 'prod_V1LEgIUdMz8tpQ',
            'features' => [
                '50 Créditos de Envio /mês',
                'Gestão de Vagas Ilimitada',
                'Templates de E-mail Padrão',
            ],
        ]);

        $proPlan = Plan::factory()->create([
            'name' => 'Profissional',
            'slug' => 'profissional',
            'description' => 'Para candidatos ativos que buscam o próximo nível na carreira.',
            'price' => 59.90,
            'interval' => 'month',
            'credits_included' => 150,
            'gateway_id' => 'prod_V1LEgIUdMz8tpQ',
            'features' => [
                '150 Créditos de Envio /mês',
                'IA Assistant (Personalização)',
                'Suporte Prioritário',
                'Relatórios de Performance',
            ],
        ]);

        $elitePlan = Plan::factory()->create([
            'name' => 'Elite',
            'slug' => 'elite',
            'description' => 'Potência máxima para quem tem pressa em ser contratado.',
            'price' => 99.90,
            'interval' => 'month',
            'credits_included' => 0,
            'gateway_id' => 'prod_V1LEgIUdMz8tpQ',
            'features' => [
                'Créditos Ilimitados',
                'Consultoria de Currículo (IA)',
                'Insights Exclusivos do Mercado',
                'Early Access a Novas Vagas',
            ],
        ]);

        // Assinatura ativa do usuário candidato no plano Profissional
        $paymentService->subscribe($candidatoUser, $proPlan, 'sub_demo_123', 'demo');

        // Adiciona currículos de demonstração
        \App\Models\Curriculo::create([
            'user_id' => $candidatoUser->id,
            'description' => 'Currículo Português',
            'external_url' => 'https://example.com/cv-pt',
            'language' => 'pt_br',
        ]);

        $enCurriculo = \App\Models\Curriculo::create([
            'user_id' => $candidatoUser->id,
            'description' => 'Resume English',
            'external_url' => 'https://example.com/cv-en',
            'language' => 'us',
        ]);

        $candidatoUser->update([
            'default_curriculo_id' => $enCurriculo->id,
            'github_link' => 'https://github.com/demo-user',
            'linkedin_link' => 'https://linkedin.com/in/demo-user',
            'application_text' => "Olá, estou muito interessado nesta vaga.\nAcredito que minhas habilidades em PHP e Laravel são ideais para o time.",
            'cover_letter' => "Gostaria de me apresentar formalmente para a posição...",
        ]);

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
