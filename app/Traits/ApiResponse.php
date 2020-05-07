<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponse
{
    public function showAll(Collection $collection, $code)
    {
        return response()->json($collection, $code);
    }

    public function showOne(Model $resource, $code)
    {
        return response()->json($resource, $code);
    }

    public function successResponse($message, $code)
    {
        // $title = intl_error_name($code);
        return response()->json([
            'success' => [
                // 'title' => $title,
                'details' => $message,
                'code' => $code
            ]
        ], $code);
    }

    public function errorResponse($message, $code)
    {
        // $title = intl_error_name($code);
        return response()->json([
            'error' => [
                // 'title' => $title,
                'details' => $message,
                'code' => $code
            ],
        ], $code);
    }
}
