<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Clients\AppticaClientInterface;
use App\Repositories\ApplicationChartRepository;
use Illuminate\Console\Command;

/**
 * Комманда для заполнения таблицы о статистике категорий приложений - историческими данными.
 * По умолчанию - команда забирает данные за вчерашний день.
 *
 * Запуск:
 * ./artisan apptica:chart:fill
 * ./artisan apptica:chart:fill --last-month
 *
 * Опции:
 * --last-month - заполнение таблицы данными за последний месяц
 */
class ActualizeApplicationsChart extends Command
{
    protected $signature = 'apptica:chart:fill
                            {--last-month : Получение данных за последний месяц}';

    protected $description = 'Команда для синхронизации статистических данных';

    public function handle(): int
    {
        $this->output->info($this->description);

        $this->output->confirm('Запустить команду для синхронизации данных?');

        $this->syncChart();

        return self::SUCCESS;
    }

    private function syncChart(): void
    {
        /** @var AppticaClientInterface $appticaClient */
        $appticaClient = resolve(AppticaClientInterface::class);
        /** @var ApplicationChartRepository $appChartRepo */
        $appChartRepo = resolve(ApplicationChartRepository::class);

        if ($this->option('last-month')) {
            $stats = $appticaClient->getStatsByDatePeriod(now()->subDays(30), now()->subDay());
        } else {
            $stats = $appticaClient->getStatsByDate(now()->subDay()->startOfDay());
        }

        $appChartRepo->storeByStatsDto($stats);
    }
}
