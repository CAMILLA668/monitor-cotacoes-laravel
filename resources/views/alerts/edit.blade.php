@extends('layouts.app')

@section('title', 'Editar Alerta — MarketWatch Analytics')

@section('content')

    <div class="max-w-2xl mx-auto">

        <div class="mb-8">

            <a href="{{ route('alerts.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                ← Voltar para alertas
            </a>

            <h1 class="text-2xl font-bold mt-3">
                Editar Alerta
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Salvar as alterações reativa o monitoramento.
            </p>

        </div>

        <div class="bg-slate-900 border border-slate-800
                    rounded-xl p-6">

            @if ($errors->any())

                <div
                    class="mb-6 rounded-lg border border-red-500/30
                            bg-red-500/10 p-4 text-sm text-red-300">

                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>

            @endif

            <form method="POST" action="{{ route('alerts.update', $alert) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>

                    <label for="asset_id" class="block text-sm text-slate-300 mb-2">
                        Ativo
                    </label>

                    <select id="asset_id" name="asset_id" required
                        class="w-full rounded-lg border border-slate-700
                               bg-slate-950 px-4 py-3
                               text-slate-100 focus:outline-none
                               focus:border-indigo-500">

                        @foreach ($assets as $asset)
                            <option value="{{ $asset->id }}" @selected(old('asset_id', $alert->asset_id) == $asset->id)>
                                {{ $asset->name }}
                                ({{ $asset->code }})
                            </option>
                        @endforeach

                    </select>

                </div>

                <div>

                    <label for="target_price" class="block text-sm text-slate-300 mb-2">
                        Preço alvo
                    </label>

                    <input id="target_price" type="number" name="target_price" step="0.0001" min="0.0001"
                        value="{{ old('target_price', $alert->target_price) }}" required
                        class="w-full rounded-lg border border-slate-700
                               bg-slate-950 px-4 py-3
                               text-slate-100 focus:outline-none
                               focus:border-indigo-500">

                </div>

                <div>

                    <label for="condition" class="block text-sm text-slate-300 mb-2">
                        Condição
                    </label>

                    <select id="condition" name="condition" required
                        class="w-full rounded-lg border border-slate-700
                               bg-slate-950 px-4 py-3
                               text-slate-100 focus:outline-none
                               focus:border-indigo-500">

                        <option value="above" @selected(old('condition', $alert->condition) === 'above')>
                            Maior ou igual
                        </option>

                        <option value="below" @selected(old('condition', $alert->condition) === 'below')>
                            Menor ou igual
                        </option>

                    </select>

                </div>

                <div
                    class="rounded-lg border border-yellow-500/20
                            bg-yellow-500/5 p-4 text-sm text-yellow-300">
                    Salvar o alerta novamente fará com que ele volte para o
                    estado de monitoramento.
                </div>

                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('alerts.index') }}"
                        class="rounded-lg border border-slate-700
                               px-4 py-2.5 text-sm
                               hover:bg-slate-800">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600
                               px-5 py-2.5 text-sm
                               font-semibold text-white
                               hover:bg-indigo-500">
                        Salvar e reativar
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
