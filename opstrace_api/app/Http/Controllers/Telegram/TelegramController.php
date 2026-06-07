<?php

namespace App\Http\Controllers\Telegram;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    use ApiResponse;
    public function handle(Request $request) {
        Telegram::commandsHandler(true);

        return $this->successResponse("ok");
    }

    public function setWebhook() {
        Telegram::setWebhook([
            'url' => config('telegram.bots.mybot.webhook_url')
        ]);

        return $this->successResponse("Webhook configured successfully");
    }
}
