<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BaseController extends Controller
{


    public function __construct()
    {
    }

    /**
     * Returns a formatted success response.
     *
     * @param array|null $data
     * @param string $message
     * @param int|Response $status
     * @return JsonResponse
     */
    public static function sendSuccessResponse($data = null, string $message = '', int|Response $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    /**
     * Returns a formatted error response.
     *
     * @param array|null $data
     * @param string $message
     * @param int|Response $status
     * @return JsonResponse
     */
    public static function sendErrorResponse(array|null $data = null, string $message = '', int|Response $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message,
        ], $status);
    }
}
