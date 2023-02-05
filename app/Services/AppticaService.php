<?php

declare(strict_types=1);

namespace App\Services;

use App\Clients\AppticaClientInterface;
use App\Models\ApplicationChart;
use App\Repositories\ApplicationChartRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AppticaService
{
    public function __construct(
        protected AppticaClientInterface $appticaClient,
        protected ApplicationChartRepository $chartRepository
    ) {
    }

    public function getDailyStats(Carbon $date): array
    {
        if ($date->lessThan(now()->startOfDay())) {
            return $this->getSavedChart($date);
        }

        return $this->getExternalChart($date);
    }

    private function getSavedChart(Carbon $date): array
    {
        $chart = ApplicationChart::byDate($date)
            ->selectRaw("category_id, min(position) as position")
            ->groupBy('category_id')
            ->orderBy('position')
            ->get();

        $data = [];

        $chart->transform(function (ApplicationChart $chart) use (&$data) {
            $data[$chart->category_id] = $chart->position;
        });

        return $this->transformResponse($data);
    }

    private function getExternalChart(Carbon $date): array
    {
        $stats = $this->appticaClient->getStatsByDate($date);

        $this->chartRepository->storeByStatsDto($stats);

        return $this->getSavedChart($date);
    }

    private function transformResponse(array $data): array
    {
        return [
            'status_code' => Response::HTTP_OK,
            'message' => 'ok',
            'data' => $data,
        ];
    }
}
