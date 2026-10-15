<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'MarketWatch Analytics')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">

    <nav class="border-b border-slate-800 bg-slate-900">

        <div class="max-w-7xl mx-auto px-6">

            <div class="h-16 flex items-center justify-between">

                <div class="flex items-center gap-6">

                    <a
                        href="{{ route('assets.index') }}"
                        class="font-bold text-lg"
                    >
                        MarketWatch
                    </a>

                    <div class="hidden md:flex items-center gap-4">

                        <a
                            href="{{ route('assets.index') }}"
                            class="text-sm text-slate-300 hover:text-white"
                        >
                            Ativos
                        </a>

                        <a
                            href="{{ route('alerts.index') }}"
                            class="text-sm text-slate-300 hover:text-white"
                        >
                            Meus Alertas
                        </a>

                    </div>

                </div>

                <div class="flex items-center gap-4">

                    <span class="hidden sm:block text-sm text-slate-400">
                        {{ auth()->user()->name }}
                    </span>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="text-sm text-slate-400 hover:text-red-400"
                        >
                            Sair
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </nav>

    <main class="max-w-7xl mx-auto p-6">

        @if(session('success'))
            <div class="mb-6 rounded-lg border border-green-500/30
                        bg-green-500/10 p-4 text-sm text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg border border-red-500/30
                        bg-red-500/10 p-4 text-sm text-red-300">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </main>

</body>

</html>
