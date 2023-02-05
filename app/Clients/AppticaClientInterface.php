<?php

declare(strict_types=1);

namespace App\Clients;

use App\Dto\StatsResponseDto;
use Carbon\Carbon;

interface AppticaClientInterface
{
    public function getStatsByDate(Carbon $date): StatsResponseDto;

    public function getStatsByDatePeriod(Carbon $dateFrom, Carbon $dateTo): StatsResponseDto;
}
