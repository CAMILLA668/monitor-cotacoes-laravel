@extends('layouts.app')

@section('title', 'Meus Alertas — MarketWatch Analytics')

@section('content')

    <div class="flex flex-col md:flex-row md:items-center
                md:justify-between gap-4 mb-8">

        <div>

            <h1 class="text-2xl font-bold">
                Meus Alertas
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Monitore preços definidos por você.
            </p>

        </div>

        <a href="{{ route('alerts.create') }}"
            class="rounded-lg bg-indigo-600 px-4 py-2
                   text-sm font-semibold text-white
                   hover:bg-indigo-500">
            Novo Alerta
        </a>

    </div>

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
                            Alvo
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Condição
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Status
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Disparado em
                        </th>

                        <th class="p-4 text-xs uppercase text-slate-400">
                            Ações
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-800">

                    @forelse($alerts as $alert)
                        <tr class="hover:bg-slate-800/40">

                            <td class="p-4">

                                <div class="font-semibold">
                                    {{ $alert->asset->name }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $alert->asset->code }}
                                </div>

                            </td>

                            <td class="p-4 font-semibold">
                                R$
                                {{ number_format((float) $alert->target_price, 4, ',', '.') }}
                            </td>

                            <td class="p-4 text-sm text-slate-300">
                                {{ $alert->condition === 'above' ? 'Maior ou igual' : 'Menor ou igual' }}
                            </td>

                            <td class="p-4">

                                @if ($alert->is_triggered)
                                    <span
                                        class="inline-flex rounded-full
                                                 bg-green-500/10 px-3 py-1
                                                 text-xs text-green-400">
                                        Atingido
                                    </span>
                                @else
                                    <span
                                        class="inline-flex rounded-full
                                                 bg-yellow-500/10 px-3 py-1
                                                 text-xs text-yellow-400">
                                        Monitorando
                                    </span>
                                @endif

                            </td>

                            <td class="p-4 text-sm text-slate-400">
                                {{ $alert->triggered_at?->format('d/m/Y H:i:s') ?? '-' }}
                            </td>

                            <td class="p-4">

                                <div class="flex items-center gap-3">

                                    <a href="{{ route('alerts.edit', $alert) }}"
                                        class="text-indigo-400 hover:text-indigo-300
                                               text-sm">
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('alerts.destroy', $alert) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="text-red-400 hover:text-red-300
                                                   text-sm">
                                            Excluir
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="p-10 text-center">
                                <p class="text-slate-400">
                                    Nenhum alerta cadastrado.
                                </p>

                                <a href="{{ route('alerts.create') }}"
                                    class="inline-block mt-3
                                           text-indigo-400 hover:text-indigo-300
                                           text-sm">
                                    Criar primeiro alerta
                                </a>
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
