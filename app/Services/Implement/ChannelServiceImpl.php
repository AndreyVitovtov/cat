<?php


namespace App\Services\Implement;


use App\models\Channel;
use App\Services\Contracts\ChannelService;

class ChannelServiceImpl implements ChannelService {
    function add(array $dataChannel): int {
        $channel = new Channel;
        $channel->name = $dataChannel['name'];
        $channel->avatar = $dataChannel['avatar'];
        $channel->users_id = $dataChannel['users_id'];
        $channel->countries_id = $dataChannel['countries_id'];
        $channel->categories_id = $dataChannel['categories_id'];
        $channel->link = $dataChannel['link'];
        $channel->save();
        return $channel->id;
    }

    function checkPresence(string $link): bool {
        return Channel::where('link', $link)->exists();
    }

    function edit(int $id, array $dataChannel): void {
        $channel = Channel::find($id);

        if(isset($dataChannel['name'])) {
            $channel->name = $dataChannel['name'];
        }

        if(isset($dataChannel['avatar'])) {
            $channel->avatar = $dataChannel['avatar'];
        }

        if(isset($dataChannel['countries_id'])) {
            $channel->countries_id = $dataChannel['countries_id'];
        }

        if(isset($dataChannel['categories_id'])) {
            $channel->categories_id = $dataChannel['categories_id'];
        }

        if(isset($dataChannel['link'])) {
            $channel->categories_id = $dataChannel['link'];
        }

        $channel->save();
    }

    function delete(int $id): void {
        Channel::where('id', $id)->delete();
    }
}
