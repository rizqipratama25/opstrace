<?php

namespace App\Telegram\Commands;

use App\Jobs\SaveUserTelegramInfo;
use App\Models\User;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start Command to get you started';

    public function handle(): void 
    {
        $username = $this->getUpdate()->getMessage()->from->username;
        $chatId = $this->getUpdate()->getMessage()->from->id;

        SaveUserTelegramInfo::dispatch($username, $chatId);

        $this->replyWithMessage([
            'text' => "👋 Hello, I'm opstrace bot. Please wait a moment..."
        ]);
    }
}