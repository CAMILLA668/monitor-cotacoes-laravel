<?php

namespace App\Console\Commands;

use App\Services\AlertService;
use App\Services\QuoteService;
use Illuminate\Console\Command;

class UpdateQuotesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotes:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza cotações, histórico e verifica alertas';

    /**
     * Execute the console command.
     */
    public function handle(
        QuoteService $quotes,
        AlertService $alerts
    ): int
    {
        $this->info('Atualizando cotações...');

        try {
            $updated = $quotes->update();

            $triggered = $alerts->processPendingAlerts();

            $this->info(
                "Ativos Atualizados: {$updated}"
            );

            $this->info(
                "Alertas disparados: {$triggered}"
            );

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error(
                $e->getMessage()
            );

            return self::FAILURE;
        }
    }
}
