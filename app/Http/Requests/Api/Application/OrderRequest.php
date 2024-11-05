<?php

namespace App\Http\Requests\Api\Application;

use App\Enums\HttpCode;
use App\Http\Requests\Core\Interfaces\PostmanRequestInterface;
use App\Postman\PostmanRequestBody;
use App\Postman\PostmanResponse;
use App\Postman\PostmanResponseExample;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest implements PostmanRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string'
        ];
    }

    public function getBody(): PostmanRequestBody
    {
        return new PostmanRequestBody('raw', [
            'name' => 'test name',
            'phone' => '+998 90 900 90 90'
        ]);
    }

    public function getResponse(array $request): PostmanResponse
    {
        return new PostmanResponse($request, [
            new PostmanResponseExample(null, HttpCode::CREATED)
        ]);
    }
}
