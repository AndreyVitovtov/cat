<?php

namespace App\models\buttons;

use App\models\BotUsers;
use App\models\Category;
use App\models\Country;
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

    public static function countries(int $page) {
        $countries = Country::all();
        $countries = $countries->chunk(10);
        $buttons = [];
        foreach ($countries[$page] as $country) {
            $buttons[] = [[
                'text' => $country->name,
                'callback_data' => 'select_country__'.$country->id
            ]];
        }

        $prevPage = $page - 1;
        $nextPage = $page + 1;

        if($page > 0) {
            $buttons[] = [[
                'text' => '{prev}',
                'callback_data' => 'search_by_countries__'.$prevPage
            ]];
        }

        if(isset($countries[$page + 1])) {
            $buttons[] = [[
                'text' => '{next}',
                'callback_data' => 'search_by_countries__'.$nextPage
            ]];
        }

        return $buttons;
    }

    public static function categories(int $page) {
        $categories = Category::all();
        $categories = $categories->chunk(10);
        $buttons = [];
        foreach ($categories[$page] as $category) {
            $buttons[] = [[
                'text' => $category->name,
                'callback_data' => 'select_category__'.$category->id
            ]];
        }

        $prevPage = $page - 1;
        $nextPage = $page + 1;

        if($page > 0) {
            $buttons[] = [[
                'text' => '{prev}',
                'callback_data' => 'search_by_categories__'.$prevPage
            ]];
        }

        if(isset($categories[$page + 1])) {
            $buttons[] = [[
                'text' => '{next}',
                'callback_data' => 'search_by_categories__'.$nextPage
            ]];
        }

        return $buttons;
    }
}
