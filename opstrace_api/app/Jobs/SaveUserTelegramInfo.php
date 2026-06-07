<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Telegram\Bot\Laravel\Facades\Telegram;

class SaveUserTelegramInfo implements ShouldQueue
{
    use Queueable;

    public string $username;
    public string $chatId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $username, string $chatId)
    {
        $this->username = $username;
        $this->chatId = $chatId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where(["telegram_username" => $this->username])->firstOrFail();
        $user->update(["telegram_id" => $this->chatId]);

        Telegram::bot('mybot')->sendMessage([
            "chat_id" => $this->chatId,
            "text" => "User data retrieved successfully!\n\nName: {$user->name}\nEmail: {$user->email}\nTelegram Username: @{$user->telegram_username}"
        ]);
    }
}
