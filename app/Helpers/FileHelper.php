<?php

namespace App\Helpers;

use App\Enums\ImageExtensionsEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class FileHelper
{
    /**
     * @param UploadedFile[] $files
     * @param string $path
     * @param array $sizes
     * @return string[]
     */
    public static function uploadLocalized(array $files, string $path, array $sizes = []): array
    {
        $result = [];

        foreach ($files as $lang => $file) {
            if (!empty($file)) {
                $result[$lang] = self::upload($file, $path, $sizes);
            } else {
                $result[$lang] = null;
            }
        }

        return $result;
    }

    public static function update(UploadedFile|null $file, $oldFile, string $path, array $sizes = [])
    {
        if (!empty($file)) {
            self::delete($oldFile);
            $oldFile = self::upload($file, $path, $sizes);
        }
        return $oldFile;
    }

    public static function upload(UploadedFile $file, string $path, array $sizes = []): string
    {
        $path = 'uploads/' . $path . '/';
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $fullPath = $path . $fileName;
        Storage::directoryExists($path) || File::makeDirectory($path, 0777, true);

        if (!in_array($file->getClientOriginalExtension(), ImageExtensionsEnum::resizable())) {
            $file->storeAs($path, $fileName);
        } else {
            $image = Image::read($file);

            if (!empty($sizes)) {
                $image->scaleDown(...$sizes);
            }

            if (in_array($file->getClientOriginalExtension(), ImageExtensionsEnum::toWebpExtenstions())) {
                $image->toWebp(100);
            }

            $fullPath = str_replace($file->getClientOriginalExtension(), 'webp', $fullPath);

            $image->save($fullPath, []);
        }

        return $fullPath;
    }

    public static function updateLocalized(array $files, array $oldFiles, string $path, array $sizes = []): array
    {
        $result = [];

        foreach ($oldFiles as $lang => $oldFile) {
            if (!empty($files[$lang])) {
                $result[$lang] = self::upload($files[$lang], $path, $sizes);
                self::delete($oldFile);
            } else {
                $result[$lang] = $oldFile;
            }
        }

        return $result;
    }

    public static function delete(string|null $path): void
    {
        if ($path === null) {
            return;
        }
        if (str_contains($path, env('APP_URL'))) {
            $path = str_replace(env('APP_URL'), '', $path);
        }
        Storage::exists($path) && Storage::delete($path);
    }

    public static function deleteFromContent(array $content): void
    {
        foreach ($content as $key => $value) {
            if (in_array($key, ['media_file', 'image', 'banner', 'icon', 'preview_image', 'file']) && is_string($value)) {
                self::delete($value);
            } elseif (is_array($value)) {
                self::deleteFromContent($value);
            }
        }
    }

    public static function massDelete(array $paths): void
    {
        foreach ($paths as $path) {
            self::delete($path);
        }
    }

    public static function getType(string|null $url): string
    {
        if (empty($url)) {
            return 'image';
        }

        $array = explode('.', $url);
        $extension = end($array);

        if (in_array($extension, ImageExtensionsEnum::values())) {
            return 'image';
        } elseif ($extension === 'mp4') {
            return 'video';
        } else {
            return 'file';
        }
    }
}

function convert($size)
{
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

