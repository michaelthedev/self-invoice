<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonSerializable;

abstract class BaseController extends Controller
{
    /**
     * General Response for API
     * @param string $message
     * @param array|JsonSerializable|null $data
     * @param int $status
     * @return JsonResponse
     */
    final public function response(
        string $message,
        null|array|JsonSerializable $data = null,
        int $status = 200
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
