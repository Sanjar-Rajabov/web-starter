<?php

namespace App\Helpers;

class LocaleHelper
{
    static function localize(string $value): array
    {
        return [
            'ru' => $value,
            'uz' => $value,
            'en' => $value
        ];
    }
}
