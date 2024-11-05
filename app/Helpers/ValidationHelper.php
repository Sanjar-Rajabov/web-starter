<?php

namespace App\Helpers;

class ValidationHelper
{
    public static function localized(string $column, string $rules = 'required|string', bool $required = true): array
    {
        return [
            $column => ($required ? 'required' : 'nullable') . '|array',
            $column . '.ru' => $rules,
            $column . '.uz' => $rules,
            $column . '.en' => $rules
        ];
    }
}
