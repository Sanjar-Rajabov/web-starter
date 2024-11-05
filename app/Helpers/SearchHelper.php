<?php

namespace App\Helpers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class SearchHelper
{
    public static function whereInt(Builder $query, $column, $value): Builder
    {
        if (!is_numeric($value)) {
            return $query;
        }

        return $query->where($column, '=', (int)$value);
    }

    public static function whereBoolean(Builder $query, $column, $value): Builder
    {
        if (!in_array($value, [0, 1, true, false, '0', '1', 'true', 'false', 'TRUE', 'FALSE'])) {
            return $query;
        }

        return $query->where($column, '=', (bool)$value);
    }

    public static function whereString(Builder $query, $column, $value): Builder
    {
        if (!is_string($value)) {
            return $query;
        }

        return $query->where($column, '=', (string)$value);
    }

    public static function whereLocalized(Builder $query, $column, $value): Builder
    {
        $value = mb_strtolower($value);
        return $query->where(
            fn(Builder $query) => $query->where(DB::raw("json_extract(lower({$column}), '$.ru')"), 'LIKE', '%' . $value . '%')
                ->orWhere(DB::raw("json_extract(lower({$column}), '$.uz')"), 'LIKE', '%' . $value . '%')
                ->orWhere(DB::raw("json_extract(lower({$column}), '$.en')"), 'LIKE', '%' . $value . '%')
        );
    }
}
