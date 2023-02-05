<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\StatDto;
use App\Dto\StatsResponseDto;
use App\Models\ApplicationChart;
use Illuminate\Support\Facades\Log;

class ApplicationChartRepository
{
    public function storeChart(StatDto $dto): ApplicationChart
    {
        return ApplicationChart::firstOrCreate($dto->toArray());
    }

    public function storeByStatsDto(StatsResponseDto $dto): void
    {
        $dto->getStatsDtoCollection()->each(function (StatDto $dto) {
            try {
                $this->storeChart($dto);
            } catch (\Exception) {
                Log::error('Ошибка в записи данных о статистике.', $dto->toArray());
            }
        });
    }
}
