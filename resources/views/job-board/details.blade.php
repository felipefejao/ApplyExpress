@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vaga->cargo }} na {{ $vaga->empresa }} | ApplyExpress</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

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

        .hero-bg {
            background: radial-gradient(circle at top left, rgba(249, 115, 22, 0.08), transparent 30%),
            radial-gradient(circle at bottom right, rgba(251, 146, 60, 0.05), transparent 35%);
        }
    </style>
</head>

<body
    class="bg-[#FDFDFC] text-gray-900 dark:bg-[#09090B] dark:text-white transition-colors duration-300 min-h-screen flex flex-col">

<nav
    class="sticky top-0 z-50 border-b border-black/5 dark:border-white/10 bg-white/70 dark:bg-black/20 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-400 to-orange-500"></div>
            <span class="font-bold text-xl tracking-tight">ApplyExpress</span>
        </a>

        <div class="flex items-center gap-4">
            <button id="themeToggle"
                    class="w-10 h-10 rounded-xl border border-black/10 dark:border-white/10 hover:scale-105 transition">
                🌙
            </button>
            <a href="/admin"
               class="hidden sm:block text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white transition">Entrar</a>
            <a href="{{ route('filament.admin.auth.register') }}"
               class="bg-orange-500 hover:bg-orange-400 text-white px-5 py-3 rounded-2xl text-sm font-semibold shadow-lg shadow-orange-500/20 transition hover:-translate-y-1">Começar
                Agora</a>
        </div>
    </div>
</nav>

<main class="flex-grow hero-bg py-12">
    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-8">
            <a href="{{ route('job-board') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-500 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Voltar para o painel de vagas
            </a>
        </div>

        @if(session('success'))
            <div
                class="mb-8 p-4 rounded-2xl bg-green-50 dark:bg-green-500/10 border border-green-100 dark:border-green-500/20 text-green-700 dark:text-green-400 flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[32px] overflow-hidden shadow-xl shadow-orange-500/5">

            {{-- Header do Detalhe --}}
            <div
                class="p-8 md:p-12 border-b border-black/5 dark:border-white/5 bg-gradient-to-br from-gray-50/50 to-white dark:from-zinc-800/50 dark:to-zinc-900">
                <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                    <div
                        class="w-24 h-24 shrink-0 rounded-[28px] bg-white dark:bg-zinc-800 border border-black/5 dark:border-white/5 flex items-center justify-center text-4xl font-bold text-orange-500 shadow-sm">
                        {{ substr($vaga->empresa, 0, 1) }}
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-lg font-semibold text-orange-500 mb-2">{{ $vaga->empresa }}</h3>
                        <h1 class="text-3xl md:text-4xl font-black tracking-tight mb-4">
                            {{ $vaga->cargo }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-y-3 gap-x-6 text-gray-600 dark:text-gray-400">
                            <span class="flex items-center gap-2">
                                <i data-lucide="globe" class="w-5 h-5 opacity-50 text-orange-500"></i>
                                {{ $vaga->relocation ? 'Remoto / ' . $vaga->relocation_city : 'Remoto' }}
                            </span>

                            <span class="flex items-center gap-2">
                                <i data-lucide="calendar" class="w-5 h-5 opacity-50 text-orange-500"></i>
                                Publicada {{ $vaga->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Conteúdo --}}
            <div class="p-8 md:p-12">
                <div class="grid md:grid-cols-3 gap-12">

                    <div class="md:col-span-2 space-y-10">
                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6">Informações da
                                Vaga</h4>
                            <div
                                class="prose dark:prose-invert max-w-none text-lg leading-relaxed text-gray-600 dark:text-gray-300">
                                <p>Esta é uma excelente oportunidade para atuar como <strong>{{ $vaga->cargo }}</strong>
                                    na empresa <strong>{{ $vaga->empresa }}</strong>.</p>
                                <p>A vaga exige conhecimentos em:</p>
                                <div class="flex flex-wrap gap-3 mt-4">
                                    @php
                                        $tags = explode(',', $vaga->language ?? 'PHP,Laravel');
                                    @endphp
                                    @foreach($tags as $tag)
                                        <span
                                            class="px-4 py-2 rounded-xl bg-gray-50 dark:bg-zinc-800 border border-black/5 dark:border-white/5 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6">Detalhes
                                Adicionais</h4>
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div
                                    class="p-6 rounded-[24px] bg-orange-50/50 dark:bg-orange-500/5 border border-orange-100 dark:border-orange-500/10">
                                    <p class="text-sm text-orange-600/60 dark:text-orange-400/60 mb-1 font-bold">
                                        Recrutador</p>
                                    <p class="text-lg font-bold text-orange-900 dark:text-orange-100">{{ $vaga->recrutador ?? 'Não informado' }}</p>
                                </div>

                                <div
                                    class="p-6 rounded-[24px] bg-orange-50/50 dark:bg-orange-500/5 border border-orange-100 dark:border-orange-500/10">
                                    <p class="text-sm text-orange-600/60 dark:text-orange-400/60 mb-1 font-bold">E-mail
                                        de Contato</p>
                                    <p class="text-lg font-bold text-orange-900 dark:text-orange-100 truncate">{{ $vaga->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Ações --}}
                    <div class="space-y-6">
                        <div
                            class="p-8 rounded-[32px] bg-gray-50 dark:bg-zinc-800/50 border border-black/5 dark:border-white/5 sticky top-28">
                            <h4 class="font-bold text-xl mb-8">Ações</h4>

                            <div class="space-y-4">
                                @if(! Auth::check())
                                    <a href="{{ route('filament.admin.auth.register') }}"
                                        class="w-full bg-orange-500 hover:bg-orange-400 text-white px-6 py-5 rounded-[20px] font-bold shadow-xl shadow-orange-500/20 transition hover:-translate-y-1 flex items-center justify-center gap-3">
                                        <i data-lucide="user-plus" class="w-6 h-6"></i>
                                        Crie sua conta
                                    </a>
                                @endif



                                @if(Auth::check() && $vaga->user_id != Auth::user()->id)
                                    <form action="{{ route('job-board.apply', $vaga->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-orange-500 hover:bg-orange-400 text-white px-6 py-5 rounded-[20px] font-bold shadow-xl shadow-orange-500/20 transition hover:-translate-y-1 flex items-center justify-center gap-3">
                                            <i data-lucide="plus-circle" class="w-6 h-6"></i>
                                            Candidatar-me
                                        </button>
                                    </form>
                                @endif

                                <button id="shareBtn"
                                        class="w-full border border-black/10 dark:border-white/10 hover:border-orange-500/30 px-6 py-5 rounded-[20px] font-bold transition hover:-translate-y-1 flex items-center justify-center gap-3 bg-white dark:bg-zinc-900">
                                    <i data-lucide="share-2" class="w-5 h-5"></i>
                                    Compartilhar Vaga
                                </button>

                                <p class="text-xs text-center text-gray-500 mt-6 px-4">
                                    Ao clicar em candidatar, esta vaga será adicionada ao seu painel pessoal de
                                    rastreamento.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</main>

<footer class="border-t border-black/5 dark:border-white/10 py-10 bg-white dark:bg-black/20">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-5">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-orange-400 to-orange-500"></div>
            <span class="font-bold">ApplyExpress</span>
        </div>
        <p class="text-sm text-gray-500">© 2026 ApplyExpress. Todos os direitos reservados.</p>
    </div>
</footer>

<div id="toast" class="fixed bottom-8 right-8 z-[100] transform translate-y-20 opacity-0 transition-all duration-300">
    <div
        class="bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 font-bold">
        <i data-lucide="check" class="w-5 h-5 text-green-500"></i>
        Link copiado com sucesso!
    </div>
</div>

<script>
    lucide.createIcons();

    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        themeToggle.innerText = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
    });

    const shareBtn = document.getElementById('shareBtn');
    const toast = document.getElementById('toast');

    shareBtn.addEventListener('click', () => {
        navigator.clipboard.writeText(window.location.href).then(() => {
            toast.classList.remove('translate-y-20', 'opacity-0');

            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        });
    });
</script>

</body>
</html>
