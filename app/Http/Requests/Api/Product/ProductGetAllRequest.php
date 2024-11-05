<?php

namespace App\Http\Requests\Api\Product;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Core\Interfaces\GetAllRequestInterface;
use App\Http\Requests\Core\Interfaces\HasParamsExampleInterface;
use App\Http\Requests\Core\Interfaces\HasResponseExampleInterface;
use App\Http\Requests\Core\PaginationRequest;
use App\Models\Product;
use App\Postman\PostmanParams;
use App\Postman\PostmanResponse;
use App\Postman\PostmanResponseExample;
use Database\Factories\ProductFactory;

class ProductGetAllRequest extends PaginationRequest implements HasResponseExampleInterface, GetAllRequestInterface, HasParamsExampleInterface
{
    public function rules(): array
    {
        return [
            'filters[category_id]' => 'nullable|exists:categories,id',
            ...parent::rules()
        ];
    }

    public function getParams(): PostmanParams
    {
        return new PostmanParams([
            'filters[category_id]' => 1,
            'page' => 1,
            'limit' => 20
        ]);
    }

    public function getResponse(array $request): PostmanResponse
    {
        return new PostmanResponse($request, [
            new PostmanResponseExample(ResponseHelper::paginatedObject(
                ProductFactory::new()->count(10)->make()->map(
                    fn(Product $product) => [
                        'id' => rand(1, 10),
                        'name' => $product->name,
                        'image' => $product->image,
                        'type' => $product->type
                    ]
                )
            ))
        ]);
    }
}
