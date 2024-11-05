<?php

namespace App\Helpers;

use App\Enums\HttpCode;
use App\Enums\HttpStatus;
use App\Http\Resources\PaginationResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ResponseHelper
{
    public static function error(string $message, HttpCode $status = HttpCode::BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'statusCode' => $status->value,
            'statusDescription' => HttpStatus::status($status),
            'message' => $message
        ], $status->value);
    }

    public static function model(Model $model, string $resource = null): JsonResponse
    {
        if (!empty($resource)) {
            $data = (new $resource($model));
        } else {
            $data = $model;
        }

        return self::response($data);
    }

    public static function response(mixed $data, HttpCode $status = HttpCode::OK): JsonResponse
    {
        return response()->json([
            'statusCode' => $status->value,
            'statusDescription' => HttpStatus::status($status),
            'data' => $data
        ], $status->value);
    }

    public static function paginatedObject($items): array
    {
        return [
            'pagination' => [
                'current' => 0,
                'previous' => 0,
                'next' => 0,
                'perPage' => 0,
                'totalPage' => 0,
                'totalItem' => 0,
            ],
            'list' => $items
        ];
    }

    public static function items(Collection|LengthAwarePaginator $items, string $resource = null): JsonResponse
    {
        if (!empty($resource)) {
            $data = call_user_func([$resource, 'collection'], $items);
        } else {
            $data = $items;
        }

        if ($items instanceof LengthAwarePaginator) {
            return self::response(new PaginationResource($items));
        } else {
            return self::response([
                'pagination' => null,
                'list' => $data
            ]);
        }
    }

    public static function created(): JsonResponse
    {
        return self::response(null, HttpCode::CREATED);
    }

    public static function updated(): JsonResponse
    {
        return self::response(null);
    }

    public static function accepted(): JsonResponse
    {
        return self::response(null, HttpCode::ACCEPTED);
    }

    public static function deleted(): JsonResponse
    {
        return self::response(null, HttpCode::NO_CONTENT);
    }

    public static function redirectedWithSuccess(string $url, string $message = 'Успешно сохранено', HttpCode $status = HttpCode::OK): JsonResponse
    {
        session()->flash('success', $message);
        return ResponseHelper::response([
            'redirected' => true,
            'url' => $url
        ], $status);
    }
}
