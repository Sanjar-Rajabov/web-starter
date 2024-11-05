<?php

namespace App\Enums;

enum ImageInputTypesEnum
{
    case Image;
    case MediaFile;
    case File;
    case Any;

    public static function getMimes(self $type): string
    {
        return match ($type) {
            self::Image => 'image/png,image/jpg,image/jpeg,image/gif,image/svg',
            self::MediaFile => 'image/png,image/jpg,image/jpeg,image/gif,image/svg,video/mp4',
            self::File => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            self::Any => '',
        };
    }
}
