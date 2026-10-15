<?php

namespace App\Services;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class QuoteService
{
    public function update(): int
    {
        $url = config('services.quotes_api.url');

        if (empty($url)) {
            throw new RuntimeException(
                'URL da API de cotações não configurada.'
            );
        }

        try {
            $response = Http::withOptions([
                'verify' => base_path('cacert.pem'),
            ])
                ->timeout(10)
                ->connectTimeout(5)
                ->retry(3, 500)
                ->acceptJson()
                ->get($url);

            if ($response->failed()) {
                Log::warning(
                    'Falha HTTP na API de cotações.',
                    [
                        'status'    => $response->status(),
                        'url'       => $url,
                    ]
                );

                throw new RuntimeException(
                    'API retornou HTTP ' . $response->status()
                );
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                throw new RuntimeException(
                    'Resposta inválida da API de cotações.'
                );
            }

            $updated = 0;
            $fetchedAt = now();

            foreach ($data as $quote) {
                if (!is_array($quote)) {
                    Log::warning(
                        'Cotação ignorada: formato inválido.'
                    );

                    continue;
                }

                $code = strtoupper(
                    trim((string) ($quote['code'] ?? ''))
                );

                if (empty($code)) {
                    Log::warning(
                        'Cotação ignorada: código do ativo ausente.'
                    );

                    continue;
                }

                $asset = Asset::where('code', $code)->first();

                if (!$asset) {
                    Log::warning(
                        'Ativo não cadastrado.',
                        ['code' => $code]
                    );

                    continue;
                }

                $requiredFields = [
                    'bid',
                    'high',
                    'low',
                    'pctChange',
                ];

                foreach ($requiredFields as $field) {
                    if (
                        !array_key_exists($field, $quote) ||
                        !is_numeric($quote[$field])
                    ) {
                        Log::warning(
                            'Campo de cotação ausente ou inválido.',
                            [
                                'code' => $code,
                                'field' => $field,
                            ]
                        );

                        continue 2;
                    }
                }

                $currentPrice   = (float) $quote['bid'];
                $highPrice      = (float) $quote['high'];
                $lowPrice       = (float) $quote['low'];
                $variation24h   = (float) $quote['pctChange'];


                DB::transaction(function () use (
                    $asset,
                    $currentPrice,
                    $highPrice,
                    $lowPrice,
                    $variation24h,
                    $fetchedAt
                ) {
                    $asset->update([
                        'current_price'     => $currentPrice,
                        'high_price'        => $highPrice,
                        'low_price'         => $lowPrice,
                        'variation_24h'     => $variation24h,
                    ]);

                    $asset->priceHistories()->create([
                        'price'         => $currentPrice,
                        'high_price'    => $highPrice,
                        'low_price'     => $lowPrice,
                        'fetched_at'    => $fetchedAt,
                    ]);
                });

                $updated++;
            }

            return $updated;
        } catch (\Throwable $e) {
            Log::error(
                'Erro na atualização de cotações.',
                [
                    'message'   => $e->getMessage(),
                    'exception' => get_class($e),
                ]
            );

            throw $e;
        }
    }
}
