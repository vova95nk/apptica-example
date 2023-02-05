<?php

declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Requests\StatsRequest;
use App\Services\AppticaService;
use Illuminate\Http\JsonResponse;

class StatsAction
{
    public function __construct(protected AppticaService $service)
    {
    }

    public function __invoke(StatsRequest $request): JsonResponse
    {
        $response = $this->service->getDailyStats($request->getDate());

        return JsonResponse::fromJsonString(json_encode($response));
    }
}
