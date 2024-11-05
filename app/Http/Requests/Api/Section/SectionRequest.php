<?php

namespace App\Http\Requests\Api\Section;

use App\Helpers\ResourceHelper;
use App\Http\Requests\Core\Interfaces\PostmanRequestInterface;
use App\Postman\PostmanParams;
use App\Postman\PostmanRequestBody;
use App\Postman\PostmanResponse;
use App\Postman\PostmanResponseExample;
use Database\Seeders\AboutSeeder;
use Database\Seeders\ContactsSeeder;
use Database\Seeders\CooperationSeeder;
use Database\Seeders\HomeSeeder;
use Database\Seeders\ProductsPageSeeder;
use Database\Seeders\VacancySeeder;
use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest implements PostmanRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'required|string'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->mergeIfMissing([
            'page' => $this->route('page')
        ]);
    }

    public function getBody(): PostmanRequestBody
    {
        return new PostmanRequestBody();
    }

    public function getResponse(array $request): PostmanResponse
    {
        $homeContent = HomeSeeder::getContent();
        $aboutContent = AboutSeeder::getContent();
        $productsContent = ProductsPageSeeder::getContent();
        $contactsContent = ContactsSeeder::getContent();

        ResourceHelper::setUrl($homeContent);
        ResourceHelper::setUrl($aboutContent);
        ResourceHelper::setUrl($productsContent);
        ResourceHelper::setUrl($contactsContent);

        $responses = [];

        $request['url']['variable'] = (new PostmanParams(['page' => 'home']))->toArray();
        $responses[] = new PostmanResponseExample($homeContent, name: 'home', request: $request);

        $request['url']['variable'] = (new PostmanParams(['page' => 'about']))->toArray();
        $responses[] = new PostmanResponseExample($aboutContent, name: 'about', request: $request);

        $request['url']['variable'] = (new PostmanParams(['page' => 'products']))->toArray();
        $responses[] = new PostmanResponseExample($productsContent, name: 'products', request: $request);

        $request['url']['variable'] = (new PostmanParams(['page' => 'contacts']))->toArray();
        $responses[] = new PostmanResponseExample($contactsContent, name: 'contacts', request: $request);

        return new PostmanResponse($request, $responses);
    }
}
