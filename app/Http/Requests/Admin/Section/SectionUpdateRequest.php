<?php

namespace App\Http\Requests\Admin\Section;

use App\Helpers\FileHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class SectionUpdateRequest extends FormRequest
{
    private array $processedData = [];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = SectionRequest::getRules($this->route('page'));

        return [
            'page' => 'required|string|exists:sections,name',
            ...$rules
        ];
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
        $this->processedData = $this->all();
        $uploadInfo = SectionRequest::getUploadInfo($this->route('page'));

        $result = [];

        $this->recursive($result, $this->all(), $uploadInfo);

        $this->processedData = $result;
    }

    private function recursive(array &$array, array $data, array $uploadInfo, bool $isList = false): void
    {
        $isList = $isList ?: (
        (array_key_exists('ru', $data) || array_key_exists('uz', $data) || array_key_exists('en', $data) || $this->checkIfList($data))
        );
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $uploadInfo) || $isList) {
                if ($value instanceof UploadedFile) {
                    $array[$key] = $this->upload($value, $isList ? $uploadInfo : $uploadInfo[$key]);
                } elseif (is_array($value)) {
                    $array[$key] = [];
                    $this->recursive($array[$key], $value, $isList ? $uploadInfo : $uploadInfo[$key], array_is_list($value));
                } elseif (!empty($value)) {
                    $array[$key] = null;
                }
            } else {
                $array[$key] = $value;
            }
        }
    }

    public function upload(UploadedFile $file, array $sizes): string
    {
        $path = 'sections/' . $this->route('page');
        return FileHelper::upload($file, $path, $sizes);
    }

    private function checkIfList(array $data): bool
    {
        $list = true;
        foreach ($data as $key => $value) {
            if (!is_numeric($key)) {
                $list = false;
            }
        }
        return $list;
    }
}
