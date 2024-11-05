<?php

namespace App\Enums;

enum ImageSizeEnum: int
{
    case Small = 1024;

    case Medium = 5120;
    case High = 10240;
    case Max = 20480;

    public function getMB(): int
    {
        return round($this->value / 1024);
    }

    public function getResolution(): string
    {
        return match ($this) {
            self::Small => '1024x1024',
            self::Medium => '2560x1440',
            default => '3840x2160',
        };
    }
}
