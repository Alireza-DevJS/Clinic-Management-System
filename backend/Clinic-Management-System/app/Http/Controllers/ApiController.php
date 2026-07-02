<?php

namespace App\Http\Controllers;


use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
       protected function successResponse(
    mixed $data = null,
    int $code = 200,
    ?string $message = null
): JsonResponse {

    if ($data instanceof AnonymousResourceCollection) {

        $resource = $data->response()->getData(true);

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $resource['data'],
            'links' => $resource['links'] ?? null,
            'meta' => $resource['meta'] ?? null,
        ], $code);
    }

    return response()->json([
        'status' => 'success',
        'message' => $message,
        'data' => $data,
    ], $code);
}
    protected function errorResponse(
        string $message,
        int $code = 400,
        mixed $errors = null
    ): JsonResponse {

        $response = [
            'status'  => 'error',
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
