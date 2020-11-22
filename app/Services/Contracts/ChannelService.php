<?php


namespace App\Services\Contracts;


interface ChannelService
{
    function getModerated(int $count = 25);
    function getOnModeration(int $count = 25);
    function add(array $channel): int;
    function checkPresence(string $link): bool;
    function edit(int $id, array $dataChannel): void;
    function moderated(int $id): void;
    function delete(int $id): void;
}
