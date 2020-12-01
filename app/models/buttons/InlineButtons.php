<?php

namespace App\models\buttons;

use App\models\BotUsers;
use App\models\Language;
use Illuminate\Database\Eloquent\Collection;

class InlineButtons {
    public static function termsOfUse() {
        return [
            [
                [
                    "text" => "Условия использования",
                    "callback_data" => "termsOfUse"
                ]
            ],
            [
                [
                    "text" => "Принимаю",
                    "callback_data" => "confirming"
                ]
            ]
        ];
    }

    public static function contacts() {
        return [
            [
                [
                    "text" => "{contacts_general}",
                    "callback_data" => "general"
                ], [
                    "text" => "{contacts_access}",
                    "callback_data" => "access"
                ]
            ], [
                [
                    "text" => "{contacts_advertising}",
                    "callback_data" => "advertising"
                ], [
                    "text" => "{contacts_offers}",
                    "callback_data" => "offers"
                ]
            ]
        ];
    }

    public static function languages() {
        $languages = Language::all();

        $buttons = [];

        $buttons[] = [[
            'text' => DEFAULT_LANGUAGE,
            'callback_data' => 'language__0'
        ]];

        foreach($languages as $language) {
            $buttons[] = [[
                'text' => base64_decode($language->emoji)." ".$language->name,
                'callback_data' => 'language__'.$language->code
            ]];
        }

        return $buttons;
    }

    public static function channel($link) {
        return [[[
            "text" => "{go}",
            "url" => $link
        ]]];
    }
}
