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

    public function index() {
        return view('admin.channels.index', [
            'channels' => Channel::with(['messenger', 'country', 'category'])->paginate(25),
            'menuItem' => 'channelslist'
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

    public function top() {
        return view('admin.top.index', [
            'tops' => Top::paginate(25),
            'menuItem' => 'channelstop'
        ]);
    }

    public function delete(Request $request) {
        $channel = Channel::find($request->post('id'));
        $path = public_path()."/img/icon_channels/".$channel->avatar;
        if(file_exists($path)) {
            unlink($path);
        }
        Channel::where('id', $channel->id)->delete();
        return redirect()->to(route('channels'));
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
            'categories' => Category::all()
        ]);
    }

    public function editSave(Request $request) {
        $channel = Channel::find($request->post('id'));
        $channel->name = $request->post('name');
        $channel->countries_id = $request->post('country');
        $channel->categories_id = $request->post('category');
        $channel->save();
        return redirect()->to(route('channels'));
    }

    public function addTop(Request $request) {
        foreach($request->post('channels') as $channel) {
            if(Top::where('channels_id', $channel)->exists()) continue;
            $top = new Top();
            $top->channels_id = $channel;
            $top->save();
        }
        return redirect()->to(route('channels-top'));
    }

    public function topDelete(Request $request) {
        Top::where('id', $request->post('id'))->delete();
        return redirect()->to(route('channels-top'));
    }
}
