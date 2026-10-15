@extends('layouts.app')

@section('title', $asset->name . ' — MarketWatch Analytics')

@section('content')

    <div class="flex items-center justify-between mb-8">

        <div>
            <a href="{{ route('assets.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                ← Voltar
            </a>

            <h1 class="text-2xl font-bold mt-3">
                {{ $asset->name }}
            </h1>

            <p class="text-sm text-slate-400">
                {{ $asset->code }}
            </p>
        </div>

        <div class="text-right">

            <p class="text-2xl font-bold">
                R$
                {{ number_format((float) $asset->current_price, 4, ',', '.') }}
            </p>

            <p
                class="{{ (float) $asset->variation_24h >= 0 ? 'text-green-400' : 'text-red-400' }}">
                {{ (float) $asset->variation_24h >= 0 ? '+' : '' }}
                {{ number_format((float) $asset->variation_24h, 2, ',', '.') }}%
            </p>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

            <p class="text-xs uppercase text-slate-500">
                Máxima
            </p>

            <p class="text-xl font-bold mt-2">
                R$
                {{ number_format((float) $asset->high_price, 4, ',', '.') }}
            </p>

        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

            <p class="text-xs uppercase text-slate-500">
                Mínima
            </p>

            <p class="text-xl font-bold mt-2">
                R$
                {{ number_format((float) $asset->low_price, 4, ',', '.') }}
            </p>

        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

            <p class="text-xs uppercase text-slate-500">
                Tipo
            </p>

            <p class="text-xl font-bold mt-2">
                {{ $asset->type === 'crypto' ? 'Criptomoeda' : 'Moeda' }}
            </p>

        </div>

    </div>

    <div class="bg-slate-900 border border-slate-800
                rounded-xl overflow-hidden">

        <div class="p-5 border-b border-slate-800">

            <h2 class="font-semibold">
                Histórico de Cotações
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-800/60">

                    <tr>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Data
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

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-800">

                    @forelse($histories as $history)
                        <tr>

                            <td class="p-4 text-sm text-slate-400">
                                {{ $history->fetched_at?->format('d/m/Y H:i:s') }}
                            </td>

                            <td class="p-4 font-semibold">
                                R$
                                {{ number_format((float) $history->price, 4, ',', '.') }}
                            </td>

                            <td class="p-4 text-sm">
                                R$
                                {{ number_format((float) $history->high_price, 4, ',', '.') }}
                            </td>

                            <td class="p-4 text-sm">
                                R$
                                {{ number_format((float) $history->low_price, 4, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="p-10 text-center text-slate-500">
                                Nenhum histórico disponível.
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-5 border-t border-slate-800">
            {{ $histories->links() }}
        </div>

    </div>

@endsection
