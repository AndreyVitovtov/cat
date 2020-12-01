<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Bot\Traits\RequestHandlerTrait;
use App\models\BotUsers;
use App\models\buttons\InlineButtons;
use App\models\Category;
use App\models\Channel;
use App\models\ChannelOfModeration;
use App\models\Country;
use App\models\Language;
use App\models\Messenger;
use App\models\ParserTelegram;
use App\models\ParserViber;
use App\Services\Contracts\BotService;
use App\Services\Contracts\ChannelService;
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

    public function search_top($page = 0) {
        if(substr($this->getMessage(), 0, 4) == "http") return;

        $channelsAll = $this->channelService->getTop(MESSENGER);
        $channels = $channelsAll->chunk(10);
        $this->setInteraction('search_top', [
            'page' => (int) $page + 1
        ]);

        $this->send('{top_channels}', [
            'buttons' => isset($channels[(int) $page + 1]) ? $this->buttons()->moreBack() : $this->buttons()->back()
        ]);

        if(MESSENGER == "Telegram") {
            foreach($channels[(int) $page] as $channel) {
                $this->sendPhoto(
                    url('/img/icons_channels/'.$channel->channel->avatar),
                    $channel->channel->name,
                    [
                        'inlineButtons' => InlineButtons::channel($channel->channel->link)
                    ]
                );
            }
        }
        else {
            $this->sendCarusel([
                'richMedia' => $this->buttons()->channels($channels[(int) $page]),
                'buttons' => isset($channels[(int) $page + 1]) ? $this->buttons()->moreBack() : $this->buttons()->back()
            ]);
        }
    }

    public function search_by_countries($page = 0) {
        $page = (int) $page;
        if(MESSENGER == "Telegram") {
            $this->send('{select_country}', [
                'inlineButtons' => InlineButtons::countries($page)
            ]);
        }
        else {
            $this->sendCarusel([
                'richMedia' => $this->buttons()->countries($page),
                'buttons' => $this->buttons()->search_channels()
            ]);
        }
    }

    public function select_country($c) {
        if(substr($this->getMessage(), 0, 4) == "http") return;

        $page = 0;
        $country = $c;

        if(is_array($c)) {
            $country = $c[0];
            $page = $c[1];
        }

        $channelsAll = $this->channelService->getByCountry($country, MESSENGER);
        $channels = $channelsAll->chunk(10);
        $this->setInteraction('select_country', [
            'page' => (int) $page + 1,
            'country' => (int) $country
        ]);

        $this->send('{channels_by_country}', [
            'buttons' => isset($channels[(int) $page + 1]) ? $this->buttons()->moreBack() : $this->buttons()->back()
        ], [
            'country' => Country::find($country)->name
        ]);

        if(MESSENGER == "Telegram") {
            foreach($channels[(int) $page] as $channel) {
                $this->sendPhoto(
                    url('/img/icons_channels/'.$channel->avatar),
                    $channel->name,
                    [
                        'inlineButtons' => InlineButtons::channel($channel->link)
                    ]
                );
            }
        }
        else {
            $this->sendCarusel([
                'richMedia' => $this->buttons()->channels2($channels[(int) $page]),
                'buttons' => isset($channels[(int) $page + 1]) ? $this->buttons()->moreBack() : $this->buttons()->back()
            ]);
        }
    }

    public function search_by_categories($page = 0) {
        $page = (int) $page;
        if(MESSENGER == "Telegram") {
            $this->send('{select_category}', [
                'inlineButtons' => InlineButtons::categories($page)
            ]);
        }
        else {
            $this->sendCarusel([
                'richMedia' => $this->buttons()->categories($page),
                'buttons' => $this->buttons()->search_channels()
            ]);
        }
    }

    public function select_category($c) {
        if(substr($this->getMessage(), 0, 4) == "http") return;

        $page = 0;
        $category = $c;

        if(is_array($c)) {
            $category = $c[0];
            $page = $c[1];
        }

        $channelsAll = $this->channelService->getByCategory($category, MESSENGER);
        $channels = $channelsAll->chunk(10);
        $this->setInteraction('select_category', [
            'page' => (int) $page + 1,
            'category' => (int) $category
        ]);

        $this->send('{channels_by_category}', [
            'buttons' => isset($channels[(int) $page + 1]) ? $this->buttons()->moreBack() : $this->buttons()->back()
        ], [
            'category' => Category::find($category)->name
        ]);

        if(MESSENGER == "Telegram") {
            foreach($channels[(int) $page] as $channel) {
                $this->sendPhoto(
                    url('/img/icons_channels/'.$channel->avatar),
                    $channel->name,
                    [
                        'inlineButtons' => InlineButtons::channel($channel->link)
                    ]
                );
            }
        }
        else {
            $this->sendCarusel([
                'richMedia' => $this->buttons()->channels2($channels[(int) $page]),
                'buttons' => isset($channels[(int) $page + 1]) ? $this->buttons()->moreBack() : $this->buttons()->back()
            ]);
        }
    }

    public function more() {
        $interaction = $this->getInteraction();
        $params = json_decode($interaction['params']);
        $method = $interaction['command'];
        if(isset($params->country)) {
            $this->$method([
                $params->country,
                $params->page
            ]);
        }
        else {
            $this->$method($params->page);
        }
    }


}
