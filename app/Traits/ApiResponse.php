<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse
{
    public function showAll(Collection $collection, $code)
    {
        return response()->json(['data' => $collection], $code);
    }

    public function showOne(Model $model, $code)
    {
        return response()->json(['data' => $model], $code);
    }

    public function successResponse($message, $code)
    {
        return response()->json(['success' => $message], $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message], $code);
    }
}
