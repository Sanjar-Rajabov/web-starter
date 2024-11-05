<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function arrayStringToDot(string $string, string $replacement = '.'): string
    {
        return preg_replace('/\[(.*?)\]/', $replacement . '$1', $string);
    }

    public static function arrayStringFromDot(string $string, string $replacement = '['): string
    {
        $parts = explode('.', $string);
        return implode($replacement . ']' . $replacement, $parts);
    }
}
