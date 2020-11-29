<?php

namespace App\Http\Controllers\Admin;

use App\models\ChannelsHasTop;
use App\models\Top;
use App\Services\Contracts\ChannelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Collection;

class TopListController extends Controller {
    /**
     * @var ChannelService
     */
    private $channelSevice;

    public function __construct(ChannelService $channelService) {
        $this->channelSevice = $channelService;
    }

    public function top() {
        $top = [];
        $tops = ChannelsHasTop::all('top_id');
        foreach($tops as $t) {
            $top[] = $t->top_id;
        }

        $channels = $this->channelSevice->getTop();

        return view('admin.topList.top', [
            'menuItem' => 'toplisttop',
            'channels' => $channels,
            'top' => $top
        ]);
    }

    public function countries() {
        return view('admin.topList.countries', [
            'menuItem' => 'toplistcountry'
        ]);
    }

    public function categories() {
        return view('admin.topList.categories', [
            'menuItem' => 'toplistcategory'
        ]);
    }

    public function topSave(Request $request) {
        ChannelsHasTop::truncate();
        if($request->post('channel')) {
            foreach($request->post('channel') as $channel) {
                if(ChannelsHasTop::where('top_id', $channel)->exists()) continue;
                $top = new ChannelsHasTop();
                $top->top_id = $channel;
                $top->save();
            }
        }
        return redirect()->to(route('top-list-top'));
    }
}
