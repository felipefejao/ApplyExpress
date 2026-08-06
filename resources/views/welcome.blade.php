<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApplyExpress</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(to right, #f97316, #fb923c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass {
            backdrop-filter: blur(14px);
            background: rgba(255, 255, 255, 0.75);
        }

        .dark .glass {
            background: rgba(17, 24, 39, 0.7);
        }

        .animate-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease;
        }

        .animate-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-bg {
            background: radial-gradient(circle at top left, rgba(249, 115, 22, 0.12), transparent 30%),
            radial-gradient(circle at bottom right, rgba(251, 146, 60, 0.08), transparent 35%);
        }
    </style>
</head>

<body class="bg-[#FDFDFC] text-gray-900 dark:bg-[#09090B] dark:text-white transition-colors duration-300">

<nav
    class="sticky top-0 z-50 border-b border-black/5 dark:border-white/10 bg-white/70 dark:bg-black/20 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-400 to-orange-500"></div>
            <span class="font-bold text-xl tracking-tight">
                ApplyExpress
            </span>
        </div>

        <div class="hidden lg:flex items-center gap-10 text-sm font-medium text-gray-600 dark:text-gray-300">
            <a href="{{ route('job-board') }}" class="hover:text-black dark:hover:text-white transition">
                Painel de Vagas
            </a>

            <a href="#features" class="hover:text-black dark:hover:text-white transition">
                Funcionalidades
            </a>

            <a href="#pricing" class="hover:text-black dark:hover:text-white transition">
                Planos
            </a>

            <a href="#about" class="hover:text-black dark:hover:text-white transition">
                Sobre
            </a>
        </div>

        <div class="flex items-center gap-4">
            <button id="themeToggle"
                    class="w-10 h-10 rounded-xl border border-black/10 dark:border-white/10 hover:scale-105 transition">
                🌙
            </button>

            <a href="/admin"
               class="hidden sm:block text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white transition">
                Entrar
            </a>

            <a href="{{ route('register.index') }}"
               class="bg-orange-500 hover:bg-orange-400 text-white px-5 py-3 rounded-2xl text-sm font-semibold shadow-lg shadow-orange-500/20 transition hover:-translate-y-1">
                Começar Agora
            </a>
        </div>

    </div>
</nav>

<section class="hero-bg overflow-hidden">

    <div class="max-w-7xl mx-auto px-6 pt-28 pb-24">

        <div class="max-w-4xl mx-auto text-center">

            <div
                class="animate-up inline-flex items-center gap-2 px-4 py-2 rounded-full border border-orange-200 bg-orange-50 dark:bg-orange-500/10 dark:border-orange-500/20 text-sm text-orange-600 mb-8">
                Plataforma inteligente para candidatos modernos
            </div>

            <h1 class="animate-up text-5xl md:text-7xl font-black leading-tight tracking-tight mb-8">
                Sua próxima vaga está
                <span class="gradient-text">
                    a um clique de distância.
                </span>
            </h1>

            <p class="animate-up text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-3xl mx-auto mb-12">
                Gerencie candidaturas, otimize e-mails com IA e automatize seus envios de forma profissional.
            </p>

            <div class="animate-up flex flex-col sm:flex-row items-center justify-center gap-5 mb-20">

                <a href="{{ route('register.index') }}"
                   class="w-full sm:w-auto bg-orange-500 hover:bg-orange-400 text-white px-8 py-5 rounded-2xl text-lg font-semibold shadow-xl shadow-orange-500/20 transition hover:-translate-y-1">
                    Começar Gratuitamente
                </a>

                <a href="#"
                   class="w-full sm:w-auto border border-black/10 dark:border-white/10 hover:border-orange-300 dark:hover:border-orange-400 px-8 py-5 rounded-2xl text-lg font-semibold transition hover:-translate-y-1">
                    Ver Demonstração
                </a>

            </div>

        </div>

        <div class="animate-up max-w-6xl mx-auto">

            <div class="glass rounded-[32px] border border-black/5 dark:border-white/10 shadow-2xl overflow-hidden">

                <div class="border-b border-black/5 dark:border-white/10 p-5 flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                </div>

                <div class="grid lg:grid-cols-3 gap-6 p-8 bg-white/60 dark:bg-black/20">

                    <div
                        class="rounded-3xl bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="font-bold text-lg">
                                Candidaturas
                            </h3>

                            <span
                                class="text-sm px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-500/10 text-orange-600">
                                24 Ativas
                            </span>
                        </div>

                        <div class="space-y-4">

                            <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800">
                                <p class="font-semibold">
                                    Senior PHP Developer
                                </p>

                                <span class="text-sm text-gray-500">
                                    Remote • Alemanha
                                </span>
                            </div>

                            <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800">
                                <p class="font-semibold">
                                    Laravel Engineer
                                </p>

                                <span class="text-sm text-gray-500">
                                    Lisboa • Híbrido
                                </span>
                            </div>

                        </div>
                    </div>

                    <div
                        class="rounded-3xl bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 p-6 shadow-sm">
                        <h3 class="font-bold text-lg mb-8">
                            IA Assistant
                        </h3>

                        <div class="space-y-4">

                            <div
                                class="bg-orange-50 dark:bg-orange-500/10 border border-orange-100 dark:border-orange-500/10 rounded-2xl p-4 text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                                “Seu perfil combina muito com os requisitos da vaga. Sugiro destacar sua experiência em
                                arquitetura escalável.”
                            </div>

                            <div class="bg-gray-50 dark:bg-zinc-800 rounded-2xl p-4 text-sm leading-relaxed">
                                E-mail otimizado para recrutador gerado com sucesso.
                            </div>

                        </div>
                    </div>

                    <div
                        class="rounded-3xl bg-gradient-to-br from-orange-500 to-orange-400 text-white p-8 flex flex-col justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-widest opacity-70 mb-4">
                                Performance
                            </p>

                            <h3 class="text-6xl font-black mb-4">
                                +73%
                            </h3>

                            <p class="opacity-90 leading-relaxed">
                                Mais respostas de recrutadores usando otimização com IA.
                            </p>
                        </div>

                        <button
                            class="mt-10 bg-white text-orange-500 rounded-2xl px-5 py-4 font-semibold hover:scale-105 transition">
                            Ver Insights
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<section id="features" class="py-28">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center max-w-3xl mx-auto mb-20 animate-up">

            <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">
                Funcionalidades
            </span>

            <h2 class="text-5xl font-black mt-4 mb-6 tracking-tight">
                Tudo que você precisa para acelerar sua contratação.
            </h2>

            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                Ferramentas inteligentes para transformar sua busca por vagas em um processo organizado, automatizado e
                eficiente.
            </p>

        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            <div
                class="animate-up group bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-10 hover:-translate-y-2 transition shadow-sm">

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-2xl mb-8">
                    🔍
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Job Board Público
                </h3>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Explore e filtre vagas públicas. Candidate-se com um clique e gerencie tudo em seu painel privado.
                </p>

            </div>

            <div
                class="animate-up group bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-10 hover:-translate-y-2 transition shadow-sm">

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-2xl mb-8">
                    ⚙️
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Gestão de Vagas
                </h3>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    CRUD completo com suporte a multi-idioma, auxílio realocação e controle total de visibilidade.
                </p>

            </div>

            <div
                class="animate-up group bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-10 hover:-translate-y-2 transition shadow-sm">

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-2xl mb-8">
                    ⚡
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Automação de E-mails
                </h3>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Disparo inteligente com templates dinâmicos, controle de vazão e integração com seu perfil profissional.
                </p>

            </div>

            <div
                class="animate-up group bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-10 hover:-translate-y-2 transition shadow-sm">

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-2xl mb-8">
                    💳
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Assinaturas e Créditos
                </h3>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Sistema de planos recorrentes e transações de créditos para potencializar suas candidaturas.
                </p>

            </div>

            <div
                class="animate-up group bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-10 hover:-translate-y-2 transition shadow-sm">

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-2xl mb-8">
                    👥
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Níveis de Acesso
                </h3>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Perfis diferenciados para candidatos e empresas, com isolamento total de dados e segurança.
                </p>

            </div>

            <div
                class="animate-up group bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-10 hover:-translate-y-2 transition shadow-sm">

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-2xl mb-8">
                    ✨
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    IA Assistant
                </h3>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Otimização de e-mails e insights estratégicos para aumentar suas chances de resposta.
                </p>

            </div>

        </div>

    </div>

</section>

<section id="pricing" class="py-28 bg-gray-50/50 dark:bg-zinc-900/50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-20 animate-up">
            <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">
                Investimento
            </span>

            <h2 class="text-5xl font-black mt-4 mb-6 tracking-tight">
                Planos para acelerar sua carreira.
            </h2>

            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                Escolha o plano que melhor se adapta ao seu momento e comece a automatizar suas candidaturas hoje mesmo.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-end">

            <!-- Plano Básico -->
            <div class="animate-up bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[32px] p-10 shadow-sm hover:shadow-xl transition duration-500">
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Starter</h3>
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-black">R$ 29</span>
                        <span class="text-gray-500 text-lg">,90/mês</span>
                    </div>
                    <p class="text-gray-500 mt-4 text-sm">Ideal para quem está começando a organizar as candidaturas.</p>
                </div>

                <ul class="space-y-4 mb-10">
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        50 Créditos de Envio /mês
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Gestão de Vagas Ilimitada
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Templates de E-mail Padrão
                    </li>
                    <li class="flex items-center gap-3 text-sm opacity-40">
                        <span class="text-xl">×</span>
                        IA Assistant
                    </li>
                </ul>

                <a href="{{ route('register.index') }}" class="block text-center w-full py-4 px-6 rounded-2xl border border-orange-500 text-orange-500 font-bold hover:bg-orange-50 dark:hover:bg-orange-500/10 transition">
                    Começar Agora
                </a>
            </div>

            <!-- Plano Pro -->
            <div class="animate-up relative bg-white dark:bg-zinc-900 border-2 border-orange-500 rounded-[32px] p-10 shadow-2xl scale-105 z-10">
                <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-orange-500 text-white px-6 py-2 rounded-full text-sm font-bold tracking-wide uppercase">
                    Mais Popular
                </div>

                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Profissional</h3>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black">R$ 59</span>
                        <span class="text-gray-500 text-lg">,90/mês</span>
                    </div>
                    <p class="text-gray-500 mt-4 text-sm">Para candidatos ativos que buscam o próximo nível na carreira.</p>
                </div>

                <ul class="space-y-4 mb-10">
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        150 Créditos de Envio /mês
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        IA Assistant (Personalização)
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Suporte Prioritário
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Relatórios de Performance
                    </li>
                </ul>

                <a href="{{ route('register.index') }}" class="block text-center w-full py-5 px-6 rounded-2xl bg-orange-500 text-white font-bold shadow-lg shadow-orange-500/20 hover:bg-orange-400 hover:-translate-y-1 transition">
                    Assinar Agora
                </a>
            </div>

            <!-- Plano Elite -->
            <div class="animate-up bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[32px] p-10 shadow-sm hover:shadow-xl transition duration-500">
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Elite</h3>
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-black">R$ 99</span>
                        <span class="text-gray-500 text-lg">,90/mês</span>
                    </div>
                    <p class="text-gray-500 mt-4 text-sm">Potência máxima para quem tem pressa em ser contratado.</p>
                </div>

                <ul class="space-y-4 mb-10">
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Créditos Ilimitados
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Consultoria de Currículo (IA)
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Insights Exclusivos do Mercado
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-orange-500 text-xl">✔</span>
                        Early Access a Novas Vagas
                    </li>
                </ul>

                <a href="{{ route('register.index') }}" class="block text-center w-full py-4 px-6 rounded-2xl border border-black/10 dark:border-white/10 hover:border-orange-500 transition font-bold">
                    Contratar Elite
                </a>
            </div>

        </div>
    </div>
</section>

<section class="py-28">

    <div class="max-w-5xl mx-auto px-6">

        <div
            class="animate-up relative overflow-hidden rounded-[40px] bg-gradient-to-br from-orange-500 to-orange-400 text-white p-16 text-center shadow-2xl shadow-orange-500/20">

            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-white"></div>
                <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-white"></div>
            </div>

            <div class="relative z-10">

                <span class="uppercase tracking-[0.3em] text-sm opacity-80">
                    Suporte Premium
                </span>

                <h2 class="text-5xl font-black mt-6 mb-8">
                    Você não procura vagas sozinho.
                </h2>

                <p class="text-xl opacity-90 leading-relaxed max-w-3xl mx-auto mb-12">
                    Tenha apoio estratégico, insights inteligentes e ferramentas criadas para aumentar suas chances de
                    contratação.
                </p>

                <a href="{{ route('register.index') }}"
                   class="inline-flex bg-white text-orange-500 px-8 py-5 rounded-2xl font-bold text-lg hover:scale-105 transition">
                    Começar Agora
                </a>

            </div>

        </div>

    </div>

</section>

<section class="py-28">
    <div class="max-w-7xl mx-auto px-6">

        <div
            class="animate-up overflow-hidden rounded-[40px] border border-black/5 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-2xl">

            <div class="grid lg:grid-cols-2">

                <div class="p-14 flex flex-col justify-center">

                    <span
                        class="inline-flex w-fit px-4 py-2 rounded-full bg-orange-100 dark:bg-orange-500/10 text-orange-600 text-sm font-semibold mb-8">
                        Suporte Humanizado
                    </span>

                    <h2 class="text-5xl font-black leading-tight tracking-tight mb-8">
                        Precisa de ajuda na sua jornada profissional?
                    </h2>

                    <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-10">
                        Nossa equipe está pronta para ajudar você a otimizar candidaturas, melhorar seus e-mails e
                        aumentar suas chances de contratação com estratégias profissionais.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-5">

                        <a href="https://wa.me/5511986887658"
                           target="_blank"
                           class="inline-flex items-center justify-center gap-3 bg-orange-500 hover:bg-orange-400 text-white px-8 py-5 rounded-2xl text-lg font-semibold shadow-xl shadow-orange-500/20 transition hover:-translate-y-1">

                            <span>💬</span>
                            Falar no WhatsApp

                        </a>

                        <a href="#features"
                           class="inline-flex items-center justify-center px-8 py-5 rounded-2xl border border-black/10 dark:border-white/10 hover:border-orange-300 dark:hover:border-orange-500/30 text-lg font-semibold transition hover:-translate-y-1">
                            Ver Funcionalidades
                        </a>

                    </div>

                </div>

                <div
                    class="relative bg-gradient-to-br from-orange-500 to-orange-400 p-14 text-white flex items-center justify-center overflow-hidden">

                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-72 h-72 rounded-full bg-white"></div>
                        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full bg-white"></div>
                    </div>

                    <div class="relative z-10 max-w-md">

                        <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-8">

                            <div class="flex items-center gap-4 mb-8">

                                <div
                                    class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center text-2xl">
                                    ⚡
                                </div>

                                <div>
                                    <h3 class="text-2xl font-bold">
                                        Atendimento Rápido
                                    </h3>

                                    <p class="text-white/70 text-sm">
                                        Segunda à Sexta
                                    </p>
                                </div>

                            </div>

                            <div class="space-y-5 text-white/90 leading-relaxed">

                                <p>
                                    ✔ Suporte para otimização de currículo
                                </p>

                                <p>
                                    ✔ Estratégias para recrutadores
                                </p>

                                <p>
                                    ✔ Ajuda com automações e IA
                                </p>

                                <p>
                                    ✔ Orientação personalizada
                                </p>

                            </div>

                            <div class="mt-10 p-5 rounded-2xl bg-black/10 border border-white/10">
                                <p class="text-sm text-white/70 mb-2">
                                    WhatsApp
                                </p>

                                <h4 class="text-2xl font-black tracking-wide">
                                    (11) 9 9225-1540
                                </h4>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

<footer class="border-t border-black/5 dark:border-white/10 py-10">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-5">

        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-orange-400 to-orange-500"></div>

            <span class="font-bold">
                ApplyExpress
            </span>
        </div>

        <p class="text-sm text-gray-500">
            © 2026 ApplyExpress. Todos os direitos reservados.
        </p>

    </div>
</footer>

<script>
    const animatedElements = document.querySelectorAll('.animate-up');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, {
        threshold: 0.15
    });

    animatedElements.forEach(el => observer.observe(el));

    const themeToggle = document.getElementById('themeToggle');

    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
    });
</script>

</body>
</html>
