<?php

namespace App\Http\Controllers\Api;

use App\APIServices\TelegramAPIService;
use App\Enums\HttpCode;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Api\Application\ApplicationRequest;
use App\Http\Requests\Api\Application\OrderRequest;
use App\Models\Application;
use Illuminate\Http\JsonResponse;

class ApplicationController
{
    public function application(ApplicationRequest $request): JsonResponse
    {
        Application::query()->create([
            'type' => 'application',
            'data' => $request->validated()
        ]);

        TelegramAPIService::sendMessage(<<<EOT
*Заявка*

*Имя:* {$request->input('name')}
*Номер телефона:* {$request->input('phone')}
*Сообщение:* {$request->input('message')}
EOT
        );

        return ResponseHelper::response(null, HttpCode::CREATED);
    }

    public function order(OrderRequest $request): JsonResponse
    {
        Application::query()->create([
            'type' => 'order',
            'data' => $request->validated()
        ]);

        TelegramAPIService::sendMessage(<<<EOT
*Заказ*

*Имя:* {$request->input('name')}
*Номер телефона:* {$request->input('phone')}
EOT
        );

        return ResponseHelper::response(null, HttpCode::CREATED);
    }
}
