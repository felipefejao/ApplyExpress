<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento cancelado - ApplyExpress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#FDFDFC] text-gray-900 dark:bg-[#09090B] dark:text-white min-h-screen flex items-center justify-center">

<div class="max-w-xl mx-auto px-6 text-center">
    <div class="w-16 h-16 rounded-full bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center text-3xl mx-auto mb-6">⚠️</div>

    <h1 class="text-4xl font-black tracking-tight mb-4">Pagamento não concluído</h1>

    <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 leading-relaxed">
        O pagamento foi cancelado ou não foi aprovado. Sua conta foi criada, mas a assinatura ainda não foi ativada.
    </p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register.index') }}" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-400 text-white px-8 py-4 rounded-2xl font-semibold transition">
            Tentar novamente
        </a>

        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl border border-black/10 dark:border-white/10 hover:border-orange-300 dark:hover:border-orange-500/30 font-semibold transition">
            Voltar para home
        </a>
    </div>
</div>

</body>
</html>
