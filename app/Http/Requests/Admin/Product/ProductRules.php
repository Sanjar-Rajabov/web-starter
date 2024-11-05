<?php

namespace App\Http\Requests\Admin\Product;

use App\Enums\ImageSizeEnum;
use App\Enums\ProductTypeEnum;
use App\Helpers\ValidationHelper;

class ProductRules
{
    public static function getRules(string $type, bool $isUpdate): array
    {
        $result = match($type) {
            ProductTypeEnum::Type1->value => [
                'file' => 'required|file|max:' . ImageSizeEnum::Max->value,
                ...ValidationHelper::localized('title'),
                ...ValidationHelper::localized('description'),
                'items' => 'required|array|size:2',
                ...ValidationHelper::localized('items.*.title', 'present|string|nullable'),
                'routes' => 'required|array',
                'routes.active' => 'required|boolean',
                'routes.items' => 'required|array',
                ...ValidationHelper::localized('routes.items.*.title', 'present|string|nullable'),
                'advantages' => 'required|array',
                'advantages.active' => 'required|boolean',
                'advantages.items' => 'required|array',
                ...ValidationHelper::localized('advantages.items.*.title', 'present|string|nullable'),
                'slider' => 'required|array',
                ...ValidationHelper::localized('slider.title', 'present|string|nullable'),
                'slider.active' => 'required|boolean',
                'slider.items' => 'required|array',
                'slider.items.*.image' => ($isUpdate ? 'nullable' : 'required_if:content.slider.active,1') . '|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
                ...ValidationHelper::localized('slider.items.*.description', 'present|string|nullable'),
            ],
            ProductTypeEnum::Type2->value => [
                'file' => 'required|file|max:' . ImageSizeEnum::Max->value,
                ...ValidationHelper::localized('title'),
                'items' => 'present|array|size:2',
                ...ValidationHelper::localized('items.*.title', 'present|string|nullable'),
                'advantages' => 'required|array',
                'advantages.active' => 'required|boolean',
                'advantages.items' => 'nullable|array',
                ...ValidationHelper::localized('advantages.items.*.title', 'present|string|nullable'),
                ...ValidationHelper::localized('description', 'present|string|nullable'),
                'slider' => 'required|array',
                'slider.active' => 'required|boolean',
                'slider.items' => 'nullable|array',
                'slider.items.*.image' => ($isUpdate ? 'nullable' : 'required_if:content.slider.active,1') . '|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
                ...ValidationHelper::localized('slider.items.*.description', 'present|string|nullable'),
            ],
            ProductTypeEnum::SuperFormat->value => [
                'items' => 'required|array|min:1',
                'items.*.image' => 'required|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
                ...ValidationHelper::localized('items.*.description')
            ],
            default => []
        };

        $rules = [];

        foreach ($result as $key => $value) {
            if ($isUpdate && (str_contains($value, 'file') && str_contains($value, 'required'))) {
                $value = str_replace('required', 'nullable', $value);
            }
            $rules['content.' . $key] = $value;
        }

        return $rules;
    }

    public static function getUploadInfo(): array
    {
        return [
            'image' => [880],
            'content' => [
                'file' => [],
                'slider' => [
                    'items' => [
                        'image' => [580]
                    ]
                ],
                'items' => [
                    'image' => [880]
                ]
            ],
        ];
    }
}
