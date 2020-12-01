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

    public function top($messenger = 'Viber') {
        $top = [];
        $tops = ChannelsHasTop::all('top_id');
        foreach($tops as $t) {
            $top[] = $t->top_id;
        }

        $channels = $this->channelSevice->getTop($messenger);

        return view('admin.topList.top', [
            'menuItem' => 'toplisttop',
            'channels' => $channels,
            'top' => $top,
            'messenger' => $messenger
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
        ChannelsHasTop::join('top', 'top.id', '=', 'channels_has_top.top_id')
            ->join('channels', 'channels.id', '=', 'top.channels_id')
            ->join('messenger', 'messenger.id', '=', 'channels.messenger_id')
            ->where('messenger.name', $request->post('messenger'))
            ->delete();

        if($request->post('channel')) {
            foreach($request->post('channel') as $channel) {
                if(ChannelsHasTop::where('top_id', $channel)->exists()) continue;
                $top = new ChannelsHasTop();
                $top->top_id = $channel;
                $top->save();
            }
        }
        return redirect()->to(route('top-list-top', [
            'messenger' => $request->post('messenger')
        ]));
    }

    public function topCountry($country, $messenger = 'Viber') {
        $top = [];
        $tops = Country::with('topChannels')->where('id', $country)->first();

        foreach($tops->topChannels as $t) {
            $top[] = $t->id;
        }

        return view('admin.topList.countries', [
            'menuItem' => 'toplistcountry',
            'channels' => $this->channelSevice->getByCountry($country, $messenger),
            'top' => $top,
            'country' => $country,
            'messenger' => $messenger,
            'countryName' => Country::find($country)
        ]);
    }

    public function topCountrySave(Request $request) {
        $country = Country::find($request->post('country'));

        DB::table('channels_top_countries')
            ->join('channels', 'channels.id', '=', 'channels_top_countries.channels_id')
            ->join('messenger', 'messenger.id', '=', 'channels.messenger_id')
            ->where('messenger.name', $request->post('messenger'))
            ->where('channels_top_countries.countries_id', $request->post('country'))
            ->delete();

        if($request->post('channel') == null) {
            return redirect()->to(route('top-list-country', [
                'country' => $request->post('country'),
                'messenger' => $request->post('messenger')
            ]));
        }

        foreach($request->post('channel') as $channel) {
            $country->topChannels()->attach($channel);
        }
        return redirect()->to(route('top-list-country', [
            'country' => $request->post('country'),
            'messenger' => $request->post('messenger')
        ]));
    }

    public function topCategory($category, $messenger = 'Viber') {
        $top = [];
        $tops = Category::with('topChannels')->where('id', $category)->first();

        foreach($tops->topChannels as $t) {
            $top[] = $t->id;
        }

        return view('admin.topList.categories', [
            'menuItem' => 'toplistcategory',
            'channels' => $this->channelSevice->getByCategory($category, $messenger),
            'top' => $top,
            'category' => $category,
            'messenger' => $messenger,
            'categoryName' => Category::find($category)
        ]);
    }

    public function topCategorySave(Request $request) {
        $category = Category::find($request->post('category'));

        DB::table('channels_top_categories')
            ->join('channels', 'channels.id', '=', 'channels_top_categories.channels_id')
            ->join('messenger', 'messenger.id', '=', 'channels.messenger_id')
            ->where('messenger.name', $request->post('messenger'))
            ->where('channels_top_categories.categories_id', $request->post('category'))
            ->delete();

        if($request->post('channel') == null) {
            return redirect()->to(route('top-list-category', [
                'category' => $request->post('category'),
                'messenger' => $request->post('messenger')
            ]));
        }

        foreach($request->post('channel') as $channel) {
            $category->topChannels()->attach($channel);
        }
        return redirect()->to(route('top-list-category', [
            'category' => $request->post('category'),
            'messenger' => $request->post('messenger')
        ]));
    }
}
