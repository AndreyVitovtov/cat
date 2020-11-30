<?php

namespace App\models\buttons;

use App\models\BotUsers;
use App\models\SettingsButtons;

class ButtonsViber {
    private $btnBg;
    private $btnSize;
    private $fontColor;

    public function __construct() {
        $viewButtons = SettingsButtons::getView();
        $this->btnBg = $viewButtons->background;
        $this->fontColor = $viewButtons->color_text;
        $this->btnSize = $viewButtons->size_text;
    }

    private function button($columns, $rows, $actionBody, $text, $silent = "false") {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'reply',
            'ActionBody' => $actionBody,
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large',
            'TextVAlign' => 'middle',
			'TextHAlign' => 'center',
        ];
    }

    private function button_url($columns, $rows, $url, $text, $silent = "true") {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'open-url',
            'ActionBody' => $url,
            'OpenURLType' => 'internal',
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large'
        ];
    }

    private function button_img($columns, $rows, $actionType, $actionBody, $image, $text = "", $params = []) {
        if(isset($params['text-color']) && isset($params['text-size'])) {
            $text = '<font color="'.$params['text-color'].'" size="'.$params['text-size'].'">'.$text.'</font>';
        }
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => $actionType,
            'ActionBody' => $actionBody,
            'Image' => $image,
            'Text' => $text,
            'TextVAlign' => isset($params['TextVAlign']) ? $params['TextVAlign'] : 'middle',
			'TextHAlign' => isset($params['TextHAlign']) ? $params['TextHAlign'] : 'center',
            'TextSize' => 'large'
        ];
    }

    private function button_location($columns, $rows, $text, $silent = false) {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'location-picker',
            'ActionBody' => 'jhg',
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large',
            'TextVAlign' => 'middle',
            'TextHAlign' => 'center',
        ];
    }

    private function button_phone($columns, $rows, $text, $silent = false) {
        return [
            'Columns' => $columns,
            'Rows' => $rows,
            'ActionType' => 'share-phone',
            'ActionBody' => 'jhg',
            'BgColor' => $this->btnBg,
            'Silent' => $silent,
            'Text' => '<font color="'.$this->fontColor.'" size="'.$this->btnSize.'">'.$text.'</font>',
            'TextSize' => 'large',
            'TextVAlign' => 'middle',
            'TextHAlign' => 'center',
        ];
    }


    public function start() {
        return [
            $this->button(6, 1, 'start', '{start}')
        ];
    }

    public function main_menu($userId = null) {
//        $user = BotUsers::find($userId);

//        if($user->access == '1') {
           return [
               $this->button(6, 1, 'search_channels', '{search_channels}'),
               $this->button(6, 1, 'add_channel', '{add_channel}'),
               $this->button(6, 1, 'contacts', '{contacts}'),
           ];
    }

    public function back() {
        return [
            $this->button(6, 1, 'back', '{back}')
        ];
    }

    public function contacts() {
        return [
            $this->button(6, 1, 'general', '{contacts_general}'),
            $this->button(6, 1, 'access', '{contacts_access}'),
            $this->button(6, 1, 'advertising', '{contacts_advertising}'),
            $this->button(6, 1, 'offers', '{contacts_offers}'),
        ];
    }

    private function pagesButtons($res, $method, $name = 'name', $page = '1') {
        $res = array_slice($res, (($page - 1) * 42), 42);
        $buttons = [];
        foreach($res as $r) {
            $buttons[] = $this->button(6, 1, $method.'__'.$r->id, $r->$name);
        }

        return $buttons;
    }

    public function getPhone() {
        return [
            $this->button_phone(6, 1, '{send_phone}'),
            $this->button(6, 1, 'back', '{back}')
        ];
    }

    public function getLocation() {
        return [
            $this->button_location(6, 1, '{send_location}'),
            $this->button(6, 1, 'back', '{back}')
        ];
    }

    public function languages($languages) {
        $buttons[] = $this->button(6, 1, 'language__0', DEFAULT_LANGUAGE);
        foreach($languages as $language) {
            $buttons[] = $this->button(
                6,
                1,
                'language__'.$language->code,
                base64_decode($language->emoji).' '.$language->name
            );
        }
        return $buttons;
    }

    public function search_channels() {
        return [
            $this->button(6, 1, 'search_top', '{search_top}'),
            $this->button(3, 1, 'search_by_countries', '{search_by_countries}'),
            $this->button(3, 1, 'search_by_categories', '{search_by_categories}'),
            $this->button(6, 1, 'back', '{back}')
        ];
    }

    public function moreBack() {
        return [
            $this->button(6, 1, 'more', '{more}'),
            $this->button(6, 1, 'back', '{back}')
        ];
    }

    public function channels($channels) {
        $buttons = [];
        foreach($channels as $channel) {
            $buttons[] = $this->button_img(
                6,
                6,
                'open-url',
                $channel->channel->link,
                url('/img/icons_channels/'.$channel->channel->avatar)
            );
            $buttons[] = $this->button_url(
                6,
                1,
                $channel->channel->link,
                $channel->channel->name
            );
        }
        return $buttons;
    }
}
