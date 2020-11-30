<?php


namespace App\models\buttons;


use App\models\BotUsers;

class ButtonsTelegram {

    public static function main_menu($userId = null) {
//        $user = BotUsers::find($userId);

        return [
            ["{search_channels}"],
            ["{add_channel}"],
            ["{contacts}"]
        ];
    }

    public static function start()
    {
        return [
            ["start"]
        ];
    }

    public function back() {
        return [
            ["{back}"]
        ];
    }

    public function getPhone() {
        return [
            [[
                'text' => '{send_phone}',
                'request_contact' => true
            ], "{back}"]
        ];
    }

    public function getLocation() {
        return [
            [[
                'text' => '{send_location}',
                'request_location' => true
            ], "{back}"]
        ];
    }


    public function search_channels() {
        return [
            ['{search_top}'],
            ['{search_by_countries}', '{search_by_categories}'],
            ['{back}']
        ];
    }

    public function moreBack() {
        return [
            ['{more}'],
            ['{back}']
        ];
    }
}
