<?php

namespace App\Http\Controllers\Admin;

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
            'channels' => $this->channelService->getModerated(),
            'menuItem' => 'channelslist'
        ]);
    }

    public function moderation() {
        return view('admin.channels.moderation', [
            'channels' => $this->channelService->getOnModeration(),
            'menuItem' => 'channelsmoderation'
        ]);
    }

    public function top() {
        return view('admin.top.index', [
            'tops' => Top::paginate(25),
            'menuItem' => 'channelstop'
        ]);
    }
}
