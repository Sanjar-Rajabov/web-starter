<?php

namespace App\Http\Requests\Api\Product;

use App\Enums\ProductTypeEnum;
use App\Http\Requests\Core\GetByIdRequest;
use App\Http\Requests\Core\Interfaces\HasParamsExampleInterface;
use App\Http\Requests\Core\Interfaces\HasResponseExampleInterface;
use App\Postman\PostmanParams;
use App\Postman\PostmanResponse;
use App\Postman\PostmanResponseExample;
use Database\Factories\ProductFactory;

class ProductGetOneRequest extends GetByIdRequest implements HasParamsExampleInterface, HasResponseExampleInterface
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'page' => 'nullable|numeric',
            'limit' => 'nullable|numeric'
        ];
    }

    public function getParams(): PostmanParams
    {
        return new PostmanParams([
            'page' => 1,
            'limit' => 20
        ]);
    }

    public function getResponse(array $request): PostmanResponse
    {
        return new PostmanResponse($request, [
            new PostmanResponseExample(ProductFactory::new()->type(ProductTypeEnum::Type1)->make([
                'id' => rand(1, 10),
            ]), name: 'type-1'),
            new PostmanResponseExample(ProductFactory::new()->type(ProductTypeEnum::Type2)->make([
                'id' => rand(1, 10),
            ]), name: 'type-2'),
            new PostmanResponseExample(ProductFactory::new()->type(ProductTypeEnum::SuperFormat)->make([
                'id' => rand(1, 10),
            ]), name: 'superformat'),
        ]);
    }
}
