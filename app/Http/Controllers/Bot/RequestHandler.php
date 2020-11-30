<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Bot\Traits\RequestHandlerTrait;
use App\models\BotUsers;
use App\models\buttons\InlineButtons;
use App\models\Channel;
use App\models\ChannelOfModeration;
use App\models\Language;
use App\models\Messenger;
use App\models\ParserTelegram;
use App\models\ParserViber;
use Exception;

class RequestHandler extends BaseRequestHandler {

    use RequestHandlerTrait;

    public function selectLanguage() {
        if(MESSENGER == "Telegram") {
            $this->send('{select_language}', [
                'inlineButtons' => InlineButtons::languages()
            ]);
        }
        else {
            $this->send('{select_language}');
            $languages = Language::all();
            $count = count($languages) + 1;
            $this->sendCarusel([
                'rows' => $count,
                'richMedia' => $this->buttons()->languages($languages)
            ]);
        }
    }

    public function language($lang) {
        $this->botService->setLanguage($this->getUserId(), $lang);

        $this->send('{welcome}', [
            'buttons' => $this->buttons()->main_menu()
        ]);
    }

    public function search_channels() {
        return $this->send('{select_item_menu}', [
            'buttons' => $this->buttons()->search_channels()
        ]);
    }

    public function add_channel() {
        $this->send('{send_link_to_channel}', [
            'buttons' => $this->buttons()->back(),
            'input' => 'regular'
        ]);

        $this->setInteraction('add_channel_send_link');
    }

    public function add_channel_send_link() {
        $link = $this->getMessage();
        if(MESSENGER == "Telegram") {
            $parser = new ParserTelegram($link);
        }
        else {
            $parser = new ParserViber($link);
        }

        $link = $parser->getLink();

        if(ChannelOfModeration::where('link', $link)->exists() || Channel::where('link', $link)->exists()) {
            return $this->send('{channel_has_already_added_to_the_catalog}', [
                'buttons' => $this->buttons()->back(),
                'input' => 'regular'
            ]);
        }

        if($parser->checkLink()) {
            try {
                $channel = new ChannelOfModeration();
                $channel->link = $parser->getLink();
                $channel->users_id = $this->getUserId();

                $messenger = Messenger::where('name', MESSENGER)->first();

                $channel->messenger_id = $messenger->id;
                $channel->date = date('Y-m-d');
                $channel->time = date('H:i:s');
                $channel->save();

                $this->send('{channel_added_successfully}', [
                    'buttons' => $this->buttons()->main_menu()
                ]);
            }
            catch (Exception $e) {
                $this->send('{error}', [
                    'buttons' => $this->buttons()->back(),
                    'input' => 'regular'
                ], [
                    'error' => $e->getMessage()
                ]);
            }
        }
        else {
            $this->send('{send_link_like}', [
                'buttons' => $this->buttons()->back(),
                'input' => 'regular'
            ]);
        }
    }
}
