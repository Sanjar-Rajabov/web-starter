<?php

namespace App\Http\Requests\Admin\Category;

use App\Enums\ImageSizeEnum;
use App\Helpers\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('get')) {
            return [];
        }
        $imageRules = [
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
            'icon' => 'required|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::Small->value,
        ];
        if ($this->route()->getName() === 'admin.category.update') {
            $imageRules = [
                'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
                'icon' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::Small->value,
            ];
        }
        return [
            ...ValidationHelper::localized('name'),
            ...$imageRules,
            'position' => 'required|numeric|min:0',
            'show_on_home_page' => 'required|boolean',
            'is_published' => 'required|boolean',
        ];
    }
}
