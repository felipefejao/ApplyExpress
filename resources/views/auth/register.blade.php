<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ApplyExpress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#FDFDFC] text-gray-900 dark:bg-[#09090B] dark:text-white min-h-screen">

<div class="max-w-6xl mx-auto px-6 py-16">
    <div class="text-center mb-14">
        <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4">Crie sua conta</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400">Escolha o plano ideal e comece a automatizar suas candidaturas.</p>
    </div>

    @if ($errors->any())
        <div class="max-w-xl mx-auto mb-10 p-4 rounded-2xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="max-w-4xl mx-auto" x-data="{ selected: '{{ $plans->first()?->id }}' }">
        @csrf

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div>
                <h2 class="text-2xl font-bold mb-6">Dados pessoais</h2>

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-2">Nome completo</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-5 py-4 rounded-2xl border border-black/10 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold mb-2">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-5 py-4 rounded-2xl border border-black/10 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold mb-2">Senha</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-5 py-4 rounded-2xl border border-black/10 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold mb-2">Confirme a senha</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-5 py-4 rounded-2xl border border-black/10 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-6">Selecione um plano</h2>

                <div class="space-y-4">
                    @foreach ($plans as $plan)
                        <label
                            class="relative block rounded-3xl border p-6 cursor-pointer transition"
                            :class="selected == '{{ $plan->id }}' ? 'border-orange-500 bg-orange-50/50 dark:bg-orange-500/10' : 'border-black/10 dark:border-white/10 bg-white dark:bg-zinc-900 hover:border-orange-300 dark:hover:border-orange-500/30'"
                        >
                            <input type="radio" name="plan_id" value="{{ $plan->id }}" x-model="selected" class="sr-only"
                                {{ old('plan_id', $plans->first()?->id) == $plan->id ? 'checked' : '' }}>

                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold text-lg">{{ $plan->name }}</h3>
                                <span class="text-2xl font-black">R$ {{ number_format($plan->price, 2, ',', '.') }}</span>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $plan->description }}</p>

                            @if (! empty($plan->features) && is_array($plan->features))
                                <ul class="text-sm space-y-2">
                                    @foreach ($plan->features as $feature => $value)
                                        <li class="flex items-center gap-2">
                                            <span class="text-orange-500">✔</span>
                                            <span>{{ is_string($feature) ? $feature : $value }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-400 text-white px-10 py-5 rounded-2xl text-lg font-bold shadow-lg shadow-orange-500/20 transition hover:-translate-y-1">
                Prosseguir para pagamento
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
