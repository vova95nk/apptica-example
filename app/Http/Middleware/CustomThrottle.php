<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Log;

class CustomThrottle extends ThrottleRequests
{
    /**
     * @param Request $request
     */
    protected function resolveRequestSignature($request)
    {
        // Пример лога
        Log::info('Reg request data for example', [
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user-agent' => $request->header('user-agent')
        ]);

        return parent::resolveRequestSignature($request);
    }
}
