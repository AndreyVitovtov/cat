<?php


namespace App\Services\Contracts;


interface BotService {
    function setLanguage(int $userId, string $lang): void;
}
