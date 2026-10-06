<?php 

namespace App\Console\Commands;

use App\Services\AlertService;
use App\Services\QuoteService;
use Illuminate\Console\Command;
use Throwable;

class UpdateQuotesCommand extends Command
{
    protected $signature = 'quotes:update';

    protected $description = 
       'Atualiza as cotações, grava o histórico e verifica os alertas';

    public function __construct(
        private QuoteService $quoteService,
        private AlertService $alertService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info(
            'Iniciando atualização das cotações...'
        );

        try{
            $updatedAssets = 
               $this->quoteService->updateQuotes();

           $this->info(
              "{$updatedAssets} ativo(s) atualizado(s)."
           );

           $triggeredAlerts = 
               $this->alertService->checkAlerts();

            $this->info(
                "{$triggeredAlerts} alerta(s) disparado(s)."
            );

            $this->info(
                'Processo concluído com sucesso.'
            );

            return self::SUCCESS;
        } catch (Throwable $exception) {

            $this->error(
                'Não foi possível concluir a atualização.'
            );

            $this->error(
                $exception->getMessage()
            );

            return self::FAILURE;
        }
    }
}
?>