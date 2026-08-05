@php use Illuminate\Support\Facades\Crypt; @endphp
    <!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas | ApplyExpress</title>

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

<main class="flex-grow hero-bg py-16">
    <div class="max-w-6xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4">
                    Painel de <span class="gradient-text">Vagas</span>
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    As melhores oportunidades para desenvolvedores modernos.
                </p>
            </div>

            <div class="w-full md:w-auto">
                <form action="{{ route('job-board') }}" method="GET" class="flex items-center gap-3">
                    <div class="relative flex-grow">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Empresa, cargo ou slug..."
                            class="w-full md:w-80 pl-12 pr-4 py-3 rounded-2xl border border-black/10 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition shadow-sm"
                        >
                    </div>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-400 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-orange-500/20 transition hover:-translate-y-1">
                        Filtrar
                    </button>
                </form>
            </div>
        </div>

        {{-- Banner informativo como na imagem --}}
        <div
            class="mb-10 p-4 rounded-2xl border border-orange-100 dark:border-orange-500/20 bg-orange-50/50 dark:bg-orange-500/5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/20">
                    <i data-lucide="megaphone" class="w-5 h-5"></i>
                </div>
                <p class="text-sm font-medium text-orange-900 dark:text-orange-200">
                    Procurando talentos para sua equipe? <a href="/vagas/create"
                                                            class="underline decoration-orange-500/30 hover:decoration-orange-500">Publique
                        sua vaga agora!</a>
                </p>
            </div>
            <a href="#"
               class="text-orange-600 dark:text-orange-400 text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                Saiba mais <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="space-y-6" id="job-list">
            @include('job-board._list')
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

<script>
    // Inicializar Lucide Icons
    lucide.createIcons();

    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        themeToggle.innerText = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
    });

    // AJAX Filter
    const filterForm = document.querySelector('form');
    const jobList = document.getElementById('job-list');

    filterForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(filterForm);
        const searchParams = new URLSearchParams(formData);
        const url = `${filterForm.action}?${searchParams.toString()}`;

        // Feedback visual
        jobList.classList.add('opacity-50', 'pointer-events-none');

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const html = await response.text();
                jobList.innerHTML = html;

                // Reinicializar ícones Lucide nos novos elementos
                lucide.createIcons();

                // Atualizar URL sem reload
                window.history.pushState({}, '', url);
            }
        } catch (error) {
            console.error('Erro ao filtrar:', error);
        } finally {
            jobList.classList.remove('opacity-50', 'pointer-events-none');
        }
    });
</script>

</body>
</html>
