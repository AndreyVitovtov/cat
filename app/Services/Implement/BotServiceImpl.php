<?php


namespace App\Services\Implement;


use App\models\BotUsers;
use App\Services\Contracts\BotService;
use Illuminate\Support\Facades\File;

class BotServiceImpl implements BotService {

    function setLanguage(int $userId, string $lang): void {
        $user = BotUsers::find($userId);
        $user->language = $lang;
        $user->save();
    }

    function savePhoto($path): ? string {
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
