<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Core\Interfaces\GetAllRequestInterface;
use App\Http\Requests\Core\Interfaces\HasParamsExampleInterface;
use App\Postman\PostmanParams;
use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest implements GetAllRequestInterface, HasParamsExampleInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'nullable|int',
            'limit' => 'nullable|int'
        ];
    }

    public function getParams(): PostmanParams
    {
        return new PostmanParams([
            'page' => 1,
            'limit' => 20
        ]);
    }

}
