<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface ChannelService
{
    function add(array $channel): int;
    function checkPresence(string $link): bool;
    function edit(int $id, array $dataChannel): void;
    function delete(int $id): void;
    function activate(int $id, int $countriesId, int $categoriesIdv): ? bool;
    function saveImage(string $path): ? string;
    function getTop(): Collection;
    function getByCountry(int $countryId): Collection;
    function getByCategory(int $categoryId): Collection;
}
