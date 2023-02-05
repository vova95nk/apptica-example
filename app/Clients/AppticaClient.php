<?php

declare(strict_types=1);

namespace App\Clients;

use App\Dto\StatsResponseDto;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AppticaClient implements AppticaClientInterface
{
    public function __construct(private readonly int $appId, private readonly int $countryId)
    {
    }

    /**
     * @throws Exception
     */
    public function getStatsByDate(Carbon $date): StatsResponseDto
    {
        $response = Http::get($this->bindUri(), [
            'date_from' => $date->toDateString(),
            'date_to' => $date->toDateString(),
        ]);

        $body = json_decode($response->body(), true);

        $this->validateResponseBody($body);

        return StatsResponseDto::makeFromResponse($body);
    }

    /**
     * @throws Exception
     */
    public function getStatsByDatePeriod(Carbon $dateFrom, Carbon $dateTo): StatsResponseDto
    {
        $response = Http::get($this->bindUri(), [
            'date_from' => $dateFrom->toDateString(),
            'date_to' => $dateTo->toDateString(),
        ]);

        $body = json_decode($response->body(), true);

        $this->validateResponseBody($body);

        return StatsResponseDto::makeFromResponse($body);
    }

    /**
     * @throws Exception
     */
    private function validateResponseBody(array $body): void
    {
        $data = Arr::get($body, 'data', '');

        if (is_string($data)) {
            throw new Exception('Ошибка в получении данных о статистике. ' . $data);
        }
    }

    private function bindUri(): string
    {
        return sprintf(config('apptica.url') . '/package/top_history/%s/%d', $this->appId, $this->countryId);
    }
}
