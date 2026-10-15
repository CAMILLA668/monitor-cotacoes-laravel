@extends('layouts.app')

@section('title', 'Cotações — MarketWatch Analytics')

@section('content')

    <div class="flex flex-col md:flex-row md:items-center
                md:justify-between gap-4 mb-8">

        <div>
            <h1 class="text-2xl font-bold">
                Monitor de Cotações
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Acompanhe moedas e criptomoedas em tempo real.
            </p>
        </div>

        <div class="flex items-center gap-3">

            <a href="{{ route('alerts.index') }}"
                class="rounded-lg border border-slate-700
                       px-4 py-2 text-sm hover:bg-slate-800">
                Meus Alertas
            </a>

            <form method="POST" action="{{ route('assets.sync') }}">
                @csrf

                <button type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2
                           text-sm font-semibold text-white
                           hover:bg-indigo-500">
                    Atualizar Cotações
                </button>
            </form>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-slate-900 border border-slate-800
                    rounded-xl p-6">

            <p class="text-xs uppercase text-slate-500">
                Ativos cadastrados
            </p>

            <p class="text-3xl font-bold mt-2">
                {{ $assets->count() }}
            </p>

        </div>

        <div class="bg-slate-900 border border-slate-800
                    rounded-xl p-6">

            <p class="text-xs uppercase text-slate-500">
                Maior variação
            </p>

            @if ($topGainer)
                <p class="text-lg font-semibold mt-2">
                    {{ $topGainer->code }}
                </p>

                <p class="text-green-400 text-sm">
                    +{{ number_format((float) $topGainer->variation_24h, 2, ',', '.') }}%
                </p>
            @else
                <p class="text-slate-500 mt-2">
                    -
                </p>
            @endif

        </div>

        <div class="bg-slate-900 border border-slate-800
                    rounded-xl p-6">

            <p class="text-xs uppercase text-slate-500">
                Alertas ativos
            </p>

            <p class="text-3xl font-bold mt-2">
                {{ $activeAlertsCount }}
            </p>

        </div>

    </div>

    <form method="GET" action="{{ route('assets.index') }}"
        class="bg-slate-900 border border-slate-800
               rounded-xl p-5 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou código..."
                class="rounded-lg border border-slate-700
                       bg-slate-950 px-4 py-2.5
                       text-sm text-slate-100
                       focus:outline-none focus:border-indigo-500">

            <select name="type"
                class="rounded-lg border border-slate-700
                       bg-slate-950 px-4 py-2.5
                       text-sm text-slate-100
                       focus:outline-none focus:border-indigo-500">
                <option value="">Todos os tipos</option>

                <option value="fiat" @selected(request('type') === 'fiat')>
                    Moedas
                </option>

                <option value="crypto" @selected(request('type') === 'crypto')>
                    Criptomoedas
                </option>
            </select>

            <button type="submit"
                class="rounded-lg bg-slate-700
                       px-4 py-2.5 text-sm
                       font-semibold hover:bg-slate-600">
                Filtrar
            </button>

        </div>

    </form>

    <div class="bg-slate-900 border border-slate-800
                rounded-xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-800/60">

                    <tr class="border-b border-slate-800">

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Ativo
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Tipo
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Preço
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Máxima
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Mínima
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Variação
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Ação
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-800">

                    @forelse($assets as $asset)
                        <tr class="hover:bg-slate-800/40">

                            <td class="p-4">

                                <div class="font-semibold">
                                    {{ $asset->name }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $asset->code }}
                                </div>

                            </td>

                            <td class="p-4 text-sm text-slate-400">
                                {{ $asset->type === 'crypto' ? 'Criptomoeda' : 'Moeda' }}
                            </td>

                            <td class="p-4 font-semibold">
                                R$
                                {{ number_format((float) $asset->current_price, 4, ',', '.') }}
                            </td>

                            <td class="p-4 text-sm text-slate-300">
                                R$
                                {{ number_format((float) $asset->high_price, 4, ',', '.') }}
                            </td>

                            <td class="p-4 text-sm text-slate-300">
                                R$
                                {{ number_format((float) $asset->low_price, 4, ',', '.') }}
                            </td>

                            <td class="p-4">

                                <span
                                    class="{{ (float) $asset->variation_24h >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ (float) $asset->variation_24h >= 0 ? '+' : '' }}
                                    {{ number_format((float) $asset->variation_24h, 2, ',', '.') }}%
                                </span>

                            </td>

                            <td class="p-4">

                                <a href="{{ route('assets.show', $asset) }}"
                                    class="text-indigo-400 hover:text-indigo-300
                                           text-sm font-medium">
                                    Detalhes
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="p-10 text-center text-slate-500">
                                Nenhum ativo encontrado.
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
