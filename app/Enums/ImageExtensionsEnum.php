<?php

namespace App\Enums;

enum ImageExtensionsEnum: string
{
    case JPG = 'jpg';
    case JPEG = 'jpeg';
    case PNG = 'png';
    case GIF = 'gif';
    case SVG = 'svg';
    case WEBP = 'webp';

    public static function values()
    {
        return array_map(fn($value) => $value->value, array_values(ImageExtensionsEnum::cases()));
    }

    public static function resizable(): array
    {
        return ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    }

    public static function toWebpExtenstions(): array
    {
        return ['jpg', 'jpeg', 'png', 'svg', 'gif'];
    }
}
