<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url={{ $loginUrl }}">
    <title>Pagamento confirmado - ApplyExpress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#FDFDFC] text-gray-900 dark:bg-[#09090B] dark:text-white min-h-screen flex items-center justify-center">

<div class="max-w-xl mx-auto px-6 text-center">
    <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-500/10 flex items-center justify-center text-3xl mx-auto mb-6">✅</div>

    <h1 class="text-4xl font-black tracking-tight mb-4">Pagamento confirmado!</h1>

    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
        Seus dados e sua assinatura foram salvos com sucesso. Em instantes você será redirecionado para a tela de login.
    </p>

    <p class="text-sm text-gray-500 dark:text-gray-500 mb-10">
        Não foi redirecionado? Clique no botão abaixo.
    </p>

    <a href="{{ $loginUrl }}" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-400 text-white px-10 py-5 rounded-2xl text-lg font-bold shadow-lg shadow-orange-500/20 transition hover:-translate-y-1">
        Fazer login
    </a>
</div>

</body>
</html>
