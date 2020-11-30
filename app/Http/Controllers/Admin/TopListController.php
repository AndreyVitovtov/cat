<?php

namespace App\Http\Controllers\Admin;

use App\models\Category;
use App\models\Channel;
use App\models\ChannelsHasTop;
use App\models\Country;
use App\models\Top;
use App\Services\Contracts\ChannelService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        return view('admin.topList.select-country', [
            'menuItem' => 'toplistcountry',
            'countries' => Country::all()
        ]);
    }

    public function categories() {
        return view('admin.topList.select-category', [
            'menuItem' => 'toplistcategory',
            'categories' => Category::all()
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

    public function topCountry(Request $request) {
        $top = [];
        $tops = Country::with('topChannels')->where('id', $request->post('country'))->first();

        foreach($tops->topChannels as $t) {
            $top[] = $t->id;
        }

        return view('admin.topList.countries', [
            'menuItem' => 'toplistcountry',
            'channels' => $this->channelSevice->getByCountry($request->post('country')),
            'top' => $top,
            'country' => $request->post('country')
        ]);
    }

    public function topCountrySave(Request $request) {
        $country = Country::find($request->post('country'));
        $country->topChannels()->detach();
        foreach($request->post('channel') as $channel) {
            $country->topChannels()->attach($channel);
        }
        return redirect()->to(route('top-list-country', [
            'country' => $request->post('country')
        ]));
    }

    public function topCategory(Request $request) {
        $top = [];
        $tops = Category::with('topChannels')->where('id', $request->post('category'))->first();

        foreach($tops->topChannels as $t) {
            $top[] = $t->id;
        }

        return view('admin.topList.categories', [
            'menuItem' => 'toplistcategory',
            'channels' => $this->channelSevice->getByCategory($request->post('category')),
            'top' => $top,
            'category' => $request->post('category')
        ]);
    }

    public function topCategorySave(Request $request) {
        $category = Category::find($request->post('category'));
        $category->topChannels()->detach();
        foreach($request->post('channel') as $channel) {
            $category->topChannels()->attach($channel);
        }
        return redirect()->to(route('top-list-category', [
            'category' => $request->post('category')
        ]));
    }
}
