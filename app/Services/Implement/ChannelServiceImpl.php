<?php


namespace App\Services\Implement;


use App\models\Channel;
use App\models\ChannelOfModeration;
use App\models\ParserTelegram;
use App\models\ParserViber;
use App\Services\Contracts\ChannelService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChannelServiceImpl implements ChannelService {
    function add(array $dataChannel): int {
        $channel = new Channel;
        $channel->name = $dataChannel['name'];
        $channel->avatar = $dataChannel['avatar'];
        $channel->users_id = $dataChannel['users_id'];
        $channel->countries_id = $dataChannel['countries_id'];
        $channel->categories_id = $dataChannel['categories_id'];
        $channel->link = $dataChannel['link'];
        $channel->messenger_id = $dataChannel['messenger_id'];
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

    function activate(int $id, int $countriesId, int $categoriesId): ? bool {
        $channel = ChannelOfModeration::find($id);
        if($channel->messenger->name === "Telegram") {
            $parser = new ParserTelegram($channel->link);
        }
        else {
            $parser = new ParserViber($channel->link);
        }

        $name = $parser->getName();
        $avatar = $parser->getAvatar();

        if($avatar) {
            $avatar = $this->saveImage($avatar);
        }

        DB::beginTransaction();

        try {
            $res = $this->add([
                'name' => $name,
                'avatar' => $avatar,
                'users_id' => $channel->users_id,
                'countries_id' => $countriesId,
                'categories_id' => $categoriesId,
                'link' => $channel->link,
                'messenger_id' => $channel->messenger_id
            ]);

            $channel->delete();

            DB::commit();

            return true;
        }
        catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    function saveImage(string $path): ? string {
        $extension = File::extension($path);
        $extension = explode('?', $extension);
        $ext = $extension[0];
        $fileName = md5(md5(time().rand(0, 100000).time())).".".$ext;

        if(copy($path, public_path()."/img/icons_channels/".$fileName)) {
            return $fileName;
        }
        else {
            return null;
        }
    }
}
