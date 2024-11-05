<?php

namespace App\Http\Requests\Admin\Section;

use Illuminate\Foundation\Http\FormRequest;

class SectionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'required|string|exists:sections,name',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->route('page')
        ]);
    }
}
