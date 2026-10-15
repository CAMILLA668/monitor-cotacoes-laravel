<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login — MarketWatch Analytics</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">
                MarketWatch Analytics
            </h1>

            <p class="text-sm text-slate-400 mt-2">
                Monitor de cotações e alertas
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm text-slate-300 mb-2">
                    E-mail
                </label>

                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="email"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950
                           px-4 py-3 text-slate-100 focus:outline-none
                           focus:border-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm text-slate-300 mb-2">
                    Senha
                </label>

                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950
                           px-4 py-3 text-slate-100 focus:outline-none
                           focus:border-indigo-500">
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-indigo-600 py-3 font-semibold
                       text-white hover:bg-indigo-500 transition">
                Entrar
            </button>
        </form>

    </div>

</body>

</html>
