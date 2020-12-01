<?php

namespace App\Http\Controllers\Admin;

use App\models\Category;
use App\models\Channel;
use App\models\ChannelOfModeration;
use App\models\Country;
use App\models\ParserTelegram;
use App\models\ParserViber;
use App\models\Top;
use App\Services\Contracts\ChannelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller {


    /**
     * @var ChannelService
     */
    private $channelService;

    public function __construct(ChannelService $channelService) {
        $this->channelService = $channelService;
    }

    public function index($messenger = 'Viber') {
        return view('admin.channels.index', [
            'channels' => Channel::with(['messenger', 'country', 'category'])
                ->join('messenger', 'messenger.id', '=', 'channels.messenger_id')
                ->where('messenger.name', $messenger)
                ->paginate(25, 'channels.*'),
            'menuItem' => 'channelslist',
            'messenger' => $messenger
        ]);
    }

    public function moderation() {
        return view('admin.channels.moderation', [
            'channels' => ChannelOfModeration::paginate(25),
            'countries' => Country::all(),
            'categories' => Category::all(),
            'menuItem' => 'channelsmoderation'
        ]);
    }

    public function activate(Request $request) {
        $this->channelService->activate(
            $request->post('id'),
            $request->post('country'),
            $request->post('category')
        );

        return redirect()->to(route('channels-moderation'));
    }

    public function top($messenger = 'Viber') {
        return view('admin.top.index', [
            'tops' => $this->channelService->getTop($messenger),
            'menuItem' => 'channelstop',
            'messenger' => $messenger
        ]);
    }

    public function delete(Request $request) {
        $channel = Channel::find($request->post('id'));
        $path = public_path()."/img/icon_channels/".$channel->avatar;
        if(file_exists($path)) {
            unlink($path);
        }
        Channel::where('id', $channel->id)->delete();
        return redirect()->to(route('channels', [
            'messenger' => $request->post('messenger')
        ]));
    }

    public function moderationDelete(Request $request) {
        ChannelOfModeration::where('id', $request->post('id'))->delete();
        return redirect()->to(route('channels-moderation'));
    }

    public function edit(Request $request) {
        return view('admin.channels.edit', [
            'menuItem' => 'channelslist',
            'channel' => Channel::find($request->post('id')),
            'countries' => Country::all(),
            'categories' => Category::all(),
            'messenger' => $request->post('messenger')
        ]);
    }

    public function editSave(Request $request) {
        $channel = Channel::find($request->post('id'));
        $channel->name = $request->post('name');
        $channel->countries_id = $request->post('country');
        $channel->categories_id = $request->post('category');
        $channel->save();
        return redirect()->to(route('channels', [
            'messenger' => $request->post('messenger')
        ]));
    }

    public function addTop(Request $request) {
        $channels = $request->post('channels');
        if(! is_array($channels)) return redirect()->to(route('channels'));
        foreach($channels as $channel) {
            if(Top::where('channels_id', $channel)->exists()) continue;
            $top = new Top();
            $top->channels_id = $channel;
            $top->save();
        }
        return redirect()->to(route('channels-top', [
            'messenger' => $request->post('messenger')
        ]));
    }

    public function topDelete(Request $request) {
        Top::where('id', $request->post('id'))->delete();
        return redirect()->to(route('channels-top', [
            'messenger' => $request->post('messenger')
        ]));
    }
}
