<?php

namespace App\APIServices;

use App\APIServices\Core\APIService;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramAPIService extends APIService
{
    public function __construct()
    {
        $this->setBaseUrl(env('TELEGRAM_URL') . '/bot' . env('TELEGRAM_BOT_TOKEN'));
    }

    public static function sendMessage(string $text, string $parseMode = 'markdown', string $chatId = ''): void
    {
        if (empty($chatId)) {
            $chatId = env('TELEGRAM_CHAT_ID');
        }

        try {
            $response = (new TelegramAPIService())->get('/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode
            ]);

//            dd($response->body());
        } catch (Throwable $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
        }
    }
}
