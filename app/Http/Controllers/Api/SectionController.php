<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Core\Controller;
use App\Http\Requests\Api\Section\SectionRequest;
use App\Models\Section;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    public function getOne(SectionRequest $request): JsonResponse
    {
        /** @var Section $result */
        $result = Section::query()->where('name', $request->input('page'))->firstOrFail();

        return ResponseHelper::response($result->content);
    }

}
