<?php

namespace App\Http\Requests\Api\Category;

use App\Helpers\LocaleHelper;
use App\Http\Requests\Core\Interfaces\GetAllRequestInterface;
use App\Http\Requests\Core\Interfaces\HasParamsExampleInterface;
use App\Http\Requests\Core\Interfaces\HasResponseExampleInterface;
use App\Models\Category;
use App\Postman\PostmanParams;
use App\Postman\PostmanResponse;
use App\Postman\PostmanResponseExample;
use Illuminate\Foundation\Http\FormRequest;

class CategoryGetAllRequest extends FormRequest implements HasResponseExampleInterface, HasParamsExampleInterface, GetAllRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters.show_on_home_page' => 'nullable|boolean'
        ];
    }

    public function getParams(): PostmanParams
    {
        return new PostmanParams([
            'filters[show_on_home_page]' => 1
        ]);
    }

    public function getResponse(array $request): PostmanResponse
    {
        return new PostmanResponse($request, [
            new PostmanResponseExample([
                'pagination' => null,
                'list' => Category::factory(3)->make()->map(function (Category $category) {
                    return [
                        'id' => rand(1, 10),
                        'name' => $category->name,
                        'image' => $category->image,
                        'icon' => $category->icon,
                        'products' => [
                            ['id' => 1, 'name' => LocaleHelper::localize('Product name')],
                            ['id' => 2, 'name' => LocaleHelper::localize('Product name')],
                            ['id' => 3, 'name' => LocaleHelper::localize('Product name')],
                        ]
                    ];
                })
            ])
        ]);
    }
}
