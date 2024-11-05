<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

class MediaRule implements ValidationRule
{
    public function __construct(
        public int   $maxSize = 2048,
        public array $extensions = ['jpg', 'jpeg', 'png', 'svg', 'mp4']
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
        if (!$value instanceof UploadedFile && !is_string($value)) {
            $fail('Неверный  ' . $attribute . '. Должен быть файл или URL.');
        }

        if (is_string($value)) {
            if (!filter_var($value, FILTER_VALIDATE_URL)) {
                $fail($attribute . ' должен быть файл или URL.');
            }
        }

        if ($value instanceof UploadedFile) {
            if ($value->getError() !== UPLOAD_ERR_OK) {
                $fail('Не получилось загрузить ' . $attribute . '. Код ошибки: ' . $value->getError());
            }

            if ($value->getSize() > ($this->maxSize * 1024)) {
                $fail($attribute . ' не должен быть больше ' . $this->maxSize . 'kb.');
            }

            if (!in_array($value->extension(), $this->extensions)) {
                $fail('Расширение файла' . $attribute . ' должно быть: ' . implode(', ', $this->extensions));
            }
        }
    }
}
