<?php

namespace App\Enums;

enum ImageExtensionsEnum: string
{
    case JPG = 'jpg';
    case JPEG = 'jpeg';
    case PNG = 'png';
    case GIF = 'gif';
    case SVG = 'svg';

    public static function values()
    {
        return array_map(fn($value) => $value->value, array_values(ImageExtensionsEnum::cases()));
    }
}
