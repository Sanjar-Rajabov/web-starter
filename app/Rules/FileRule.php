<?php

namespace App\Rules;

use App\Enums\ImageInputTypesEnum;
use App\Enums\ImageSizeEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

class FileRule implements ValidationRule
{
    public function __construct(
        public bool                $required = true,
        public ImageInputTypesEnum $type = ImageInputTypesEnum::Image,
        public ImageSizeEnum       $size = ImageSizeEnum::Medium,
        public bool                $deletable = false,
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->required && empty($value)) {
            $fail('Поле ' . $attribute . ' обязательно для заполнения.');
        }

        if (is_string($value)) {
            if (!$this->deletable && $value === 'deleted') {
                $fail('Значение поле ' . $attribute . ' нельзя удалить.');
            }
            if ($value !== '' && ($this->deletable && $value !== 'deleted')) {
                $fail('Неверный  ' . $attribute . '. Должен быть файл.');
            }

            return;
        }

        if ($value instanceof UploadedFile && $value->getError() !== UPLOAD_ERR_OK) {
            $fail('Не получилось загрузить ' . $attribute . '. Код ошибки: ' . $value->getError());
        }

        if ($value instanceof UploadedFile && $value->getSize() > ($this->size->value * 1024)) {
            $fail($attribute . ' не должен быть больше ' . round($this->size->value / 1000, 1) . 'mb.');
        }

        if ($value instanceof UploadedFile && $this->type !== ImageInputTypesEnum::Any && !in_array($value->getClientOriginalExtension(), $this->type->getExtensions())) {
            $fail('Расширение файла' . $attribute . ' должно быть: ' . implode(', ', $this->type->getExtensions()));
        }
    }
}
