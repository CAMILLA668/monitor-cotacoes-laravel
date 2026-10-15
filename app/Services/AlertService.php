<?php

namespace App\Services;

use App\Mail\PriceAlertTriggered;
use App\Models\PriceAlert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AlertService
{
   public function processPendingAlerts(): int
   {
        $triggered = 0;

        PriceAlert::query()
            ->where('is_triggered', false)
            ->with(['asset', 'user'])
            ->chunkById(100, function ($alerts) use (&$triggered) {

                foreach ($alerts as $alert) {
                    if (!$alert->asset || !$alert->user) {
                        Log::warning(
                            'Alerta ignorado: relacionamento ausente.',
                            [
                                'alert_id'  => $alert->id,
                            ]
                        );

                        continue;
                    }

                    $current    = (float) $alert->asset->current_price;
                    $target     = (float) $alert->target_price;

                    if ($alert->condition === 'above') {
                        $met = $current >= $target;
                    } elseif ($alert->condition === 'below') {
                        $met = $current <= $target;
                    } else {
                        Log::warning(
                            'Condição  de alerta inválida.',
                            [
                                'alert_id'  => $alert->id,
                                'condition' => $alert->condition,
                            ]
                        );

                        continue;
                    }

                    if (!$met) {
                        continue;
                    }

                    try {
                        $triggeredAt = now();

                        Mail::to($alert->user->email)
                            ->send(
                                new PriceAlertTriggered(
                                    $alert,
                                    $triggeredAt
                                )
                            );

                        $alert->update([
                            'is_triggered'  => true,
                            'triggered_at'  => $triggeredAt,
                        ]);

                        $triggered++;
                    } catch (\Throwable $e) {
                        Log::error(
                            'Falha no envio do alerta.',
                            [
                                'alert_id'      => $alert->id,
                                'asset_id'      => $alert->asset_id,
                                'current_price' => $current,
                                'target_price'  => $target,
                                'condition'     => $alert->condition,
                                'message'       => $e->getMessage(),
                                'exception'     => get_class($e),
                            ]
                        );
                    }
                }
            });

            return $triggered;

   }
}
