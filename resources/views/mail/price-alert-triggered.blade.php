<x-mail::message>

# Alerta de preço atingido

O ativo **{{ $asset->name }} ({{ $asset->code }})**
atingiu o preço configurado.

**Preço atual:**
R$ {{ number_format((float) $asset->current_price, 4, ',', '.') }}

**Preço alvo:**
R$ {{ number_format((float) $alert->target_price, 4, ',', '.') }}

**Condição:**
{{ $alert->condition === 'above' ? 'Maior ou igual' : 'Menor ou igual' }}

**Disparado em:**
{{ $triggeredAt->format('d/m/Y H:i:s') }}

{{ config('app.name') }}

</x-mail::message>
