<?php


namespace App\Services\Implement;


use App\models\BotUsers;
use App\Services\Contracts\BotService;

class BotServiceImpl implements BotService {

    function setLanguage(int $userId, string $lang): void {
        $user = BotUsers::find($userId);
        $user->language = $lang;
        $user->save();
    }
}
