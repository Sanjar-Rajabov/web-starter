<?php

namespace App\Http\Requests\Admin\Product;

use App\Enums\ImageSizeEnum;
use App\Enums\ProductTypeEnum;
use App\Helpers\FileHelper;
use App\Helpers\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class ProductRequest extends FormRequest
{
    private array $processedData = [];

    public function authorize(): bool
    {
        return true;
    }

    public function getProcessedData(): array
    {
        return $this->processedData;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->route('page')
        ]);
    }

    protected function passedValidation(): void
    {
        $keys = array_map(fn($key) => explode('.', $key)[0], array_keys($this->rules()));

        $this->processedData = Arr::only($this->all(), $keys);

        $uploadInfo = ProductRules::getUploadInfo();

        $result = [];

        $this->recursive($result, $this->processedData, $uploadInfo);

        $this->processedData = $result;
    }

    public function rules(): array
    {
        $isCreate = $this->route()->getName() === 'admin.product.create';

        if ($this->isMethod('get')) {
            if ($isCreate) {
                return [
                    'type' => 'required|string|in:' . implode(',', array_map(fn($enum) => $enum->value, ProductTypeEnum::cases()))
                ];
            }
            return [];
        }

        return [
            ...ValidationHelper::localized('name'),
            'type' => 'required|string|in:' . implode(',', array_map(fn($enum) => $enum->value, ProductTypeEnum::cases())),
            'image' => ($isCreate ? 'required' : 'nullable') .'|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
            'position' => 'required|int',
            'show_on_home_page' => 'required|boolean',
            'is_published' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            ...ProductRules::getRules($this->input('type'), !$isCreate)
        ];
    }

    private function recursive(array &$array, array $data, array $uploadInfo, bool $isList = false): void
    {
        $isList = $isList ?: (
            array_key_exists('ru', $data) || array_key_exists('uz', $data) || array_key_exists('en', $data)
        );
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $uploadInfo) || ($isList && $key === 'media_file')) {
                if ($value instanceof UploadedFile) {
                    $array[$key] = $this->upload($value, $isList ? $uploadInfo : $uploadInfo[$key]);
                } elseif (is_array($value)) {
                    $array[$key] = [];
                    $this->recursive($array[$key], $value, $isList ? $uploadInfo : $uploadInfo[$key], array_is_list($value));
                }
            } elseif (is_array($value)) {
                $array[$key] = [];
                $this->recursive($array[$key], $value, $uploadInfo);
            } else {
                if (in_array($key, ['active', 'is_published', 'show_on_home_page'])) {
                    $array[$key] = boolval($value);
                } else {
                    $array[$key] = $value;
                }
            }
        }
    }

    public function upload(UploadedFile $file, array $sizes): string
    {
        return FileHelper::upload($file, 'products', $sizes);
    }
}
