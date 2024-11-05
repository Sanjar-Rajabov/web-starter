<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Api\Home\HomeRequest;
use App\Models\Section;
use Illuminate\Http\JsonResponse;

class PageController
{
    public function home(HomeRequest $request): JsonResponse
    {
        $homeSections = Section::query()->where('name', 'home')->first()->content;
        $contactsSection = Section::query()->where('name', 'contacts')->first()->content;

        return ResponseHelper::response([
            'home_sections' => $homeSections,
            'contacts_section' => $contactsSection
        ]);
    }
}
