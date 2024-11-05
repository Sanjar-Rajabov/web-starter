<?php

namespace App\Helpers;

class ResourceHelper
{
    public static function setUrl(array &$result): array
    {
        foreach ($result as $key => $value) {
            if (in_array($key, ['media_file', 'image', 'banner', 'icon', 'preview_image', 'file'])) {
                if (is_array($value)) {
                    foreach ($value as $k => $item) {
                        $result[$key][$k] = !empty($item) ? asset($item) : null;
                    }
                } elseif (!empty($value)) {
                    $result[$key] = asset($value);
                }
            } elseif (is_array($value)) {
                self::setUrl($result[$key]);
            }
        }

        return $result;
    }
}
