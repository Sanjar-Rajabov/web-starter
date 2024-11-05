<?php

namespace App\Http\Controllers\Admin;

use App\Enums\HttpCode;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Core\Controller;
use App\Http\Requests\Admin\Section\SectionIndexRequest;
use App\Http\Requests\Admin\Section\SectionUpdateRequest;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(SectionIndexRequest $request): View
    {
        $page = $request->input('page');
        $result = Section::query()->where('name', $page)->firstOrFail();

        return view('admin.sections.' . $page, [
            'page' => $page,
            'data' => $result->toArray()['content']
        ]);
    }

    public function update(SectionUpdateRequest $request): JsonResponse
    {
        $page = $request->input('page');
        $content = $request->getProcessedData();
        $result = Section::query()->where('name', $page)->firstOrFail();
        $result->update([
            'content' => $content
        ]);

        return ResponseHelper::response('Изменения успешно сохранены', HttpCode::CREATED);
    }
}
