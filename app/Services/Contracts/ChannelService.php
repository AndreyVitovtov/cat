<?php


namespace App\Services\Contracts;


interface ChannelService
{
    function add(array $channel): int;
    function checkPresence(string $link): bool;
    function edit(int $id, array $dataChannel): void;
    function delete(int $id): void;
    function activate(int $id, int $countriesId, int $categoriesIdv): ? bool;
    function saveImage(string $path): ? string;
}
