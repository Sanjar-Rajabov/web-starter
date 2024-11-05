<?php

namespace App\Http\Requests\Api\Home;

use App\Http\Requests\Core\Interfaces\HasResponseExampleInterface;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use App\Postman\PostmanResponse;
use App\Postman\PostmanResponseExample;
use Database\Seeders\ContactsSeeder;
use Database\Seeders\HomeSeeder;
use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest implements HasResponseExampleInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getResponse(array $request): PostmanResponse
    {
        return new PostmanResponse($request, [
            new PostmanResponseExample([
                'home_sections' => HomeSeeder::getContent(),
                'contacts_section' => ContactsSeeder::getContent()
            ])
        ]);
    }
}
