<?php

namespace App\Casts;

use App\Helpers\FileHelper;
use App\Helpers\ResourceHelper;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ContentCast implements CastsAttributes
{
    public function __construct(
        protected string|null $type = 'static'
    )
    {
    }

    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $value = json_decode($value, true);
        ResourceHelper::setUrl($value);
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @throws Exception
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!is_array($value)) {
            throw new Exception("Field $key must be an array");
        }

        $newValue = $value;
        $modelKey = $key;

        $result = [];

        if ($this->type === 'dynamic' && !$model->exists) {
            $content = $model->getExample($key);
        } else {
            $content = json_decode($model->getRawOriginal($modelKey), true);
        }

        if (!empty($content)) {
            $this->recursive($result, $newValue, $content);
        } else {
            $result = $value;
        }

        return json_encode($result);
    }

    private function recursive(array &$array, array $newValue, array $oldValue, bool $newObject = false): void
    {
        if (array_is_list($oldValue) && (array_key_first($newValue) === 0) || isset(Arr::first($newValue)['new_position'])) {
            $this->recursiveArray($array, $newValue, $oldValue);
        } else {
            foreach ($oldValue as $k => $value) {
                if (is_array($value)) {
                    $array[$k] = [];
                    if (array_key_exists($k, $newValue)) {
                        if (array_is_list($value) && (array_key_first($newValue[$k]) === 0 || isset(Arr::first($newValue[$k])['new_position']))) {
                            $this->recursiveArray($array[$k], $newValue[$k], $value);
                        } else {
                            $this->recursive($array[$k], $newValue[$k], $value);
                        }

                        if ($k === 'media_file') {
                            $array['media_file_type'] = FileHelper::getType($array[$k]['ru'] ?? $array[$k]['en'] ?? $array[$k]['uz']); // TODO should be validation. every file should be same type if media_file is localized
                        }
                    } else {
                        $this->recursive($array[$k], $value, $value);
                        if ($k === 'media_file') {
                            $array['media_file_type'] = FileHelper::getType($array[$k]['ru'] ?? $array[$k]['en'] ?? $array[$k]['uz']);
                        }
                    }
                } else {
                    $isImage = $k === 'media_file' || $k === 'image' || $k === 'banner' || $k === 'icon' || $k === 'preview_image' || $k === 'file';
                    if (array_key_exists($k, $newValue)) {
                        $array[$k] = $newValue[$k];
                        if (isset($newValue['new_position']) && isset($newValue['old_position'])) {
                            if ($newValue['new_position'] === $newValue['old_position'] && $isImage && $value !== $newValue[$k] && !$newObject) {
                                FileHelper::delete($value);
                            }
                        } elseif ($isImage && $value !== $newValue[$k] && !$newObject) {
                            FileHelper::delete($value);
                        }
                    } else {
                        $array[$k] = ($isImage && !$newObject) ? $value : null;
                    }
                    if ($k === 'media_file' || $k === 'media_file_type') {
                        $array['media_file_type'] = FileHelper::getType($array['media_file']['ru'] ?? $array['media_file']['uz'] ?? $array['media_file']['en'] ?? $array['media_file']);
                    }
                }
            }
        }
    }

    private function recursiveArray(array &$array, array $newValue, array $oldValue): void
    {
        $example = Arr::first($oldValue);
        $i = 0;

        foreach ($newValue as $k => $value) {
            if (isset($value['new_position'])) {
                $i = $value['new_position'];
                $k = $value['old_position'];
            }
            if (is_array($value)) {
                $array[$i] = [];
                $this->recursive($array[$i], $value, $oldValue[$k] ?? $example, empty($oldValue[$k]));
            } else {
                $array[$i] = $value;
            }
            if (!isset($value)) {
                $i++;
            }
        }
    }
}
