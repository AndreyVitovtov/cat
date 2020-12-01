<?php


namespace App\Services\Implement;


use App\models\Category;
use App\models\Channel;
use App\models\ChannelOfModeration;
use App\models\ChannelsHasTop;
use App\models\Country;
use App\models\Messenger;
use App\models\ParserTelegram;
use App\models\ParserViber;
use App\models\Top;
use App\Services\Contracts\ChannelService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChannelServiceImpl implements ChannelService {
    function add(array $dataChannel): int {
        $channel = new Channel;
        $channel->name = $dataChannel['name'];
        $channel->avatar = $dataChannel['avatar'];
        $channel->users_id = $dataChannel['users_id'];
        $channel->countries_id = $dataChannel['countries_id'];
        $channel->categories_id = $dataChannel['categories_id'];
        $channel->link = $dataChannel['link'];
        $channel->messenger_id = $dataChannel['messenger_id'];
        $channel->save();
        return $channel->id;
    }

    function checkPresence(string $link): bool {
        return Channel::where('link', $link)->exists();
    }

    function edit(int $id, array $dataChannel): void {
        $channel = Channel::find($id);

        if(isset($dataChannel['name'])) {
            $channel->name = $dataChannel['name'];
        }

        if(isset($dataChannel['avatar'])) {
            $channel->avatar = $dataChannel['avatar'];
        }

        if(isset($dataChannel['countries_id'])) {
            $channel->countries_id = $dataChannel['countries_id'];
        }

        if(isset($dataChannel['categories_id'])) {
            $channel->categories_id = $dataChannel['categories_id'];
        }

        if(isset($dataChannel['link'])) {
            $channel->categories_id = $dataChannel['link'];
        }

        $channel->save();
    }

    function delete(int $id): void {
        Channel::where('id', $id)->delete();
    }

    function activate(int $id, int $countriesId, int $categoriesId): ? bool {
        $channel = ChannelOfModeration::find($id);
        if($channel->messenger->name === "Telegram") {
            $parser = new ParserTelegram($channel->link);
        }
        else {
            $parser = new ParserViber($channel->link);
        }

        $name = $parser->getName();
        $avatar = $parser->getAvatar();

        if($avatar) {
            $avatar = $this->saveImage($avatar);
        }

        DB::beginTransaction();

        try {
            $res = $this->add([
                'name' => $name,
                'avatar' => $avatar,
                'users_id' => $channel->users_id,
                'countries_id' => $countriesId,
                'categories_id' => $categoriesId,
                'link' => $channel->link,
                'messenger_id' => $channel->messenger_id
            ]);

            $channel->delete();

            DB::commit();

            return true;
        }
        catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    function saveImage(string $path): ? string {
        $extension = File::extension($path);
        $extension = explode('?', $extension);
        $ext = $extension[0];
        $fileName = md5(md5(time().rand(0, 100000).time())).".".$ext;

        if(copy($path, public_path()."/img/icons_channels/".$fileName)) {
            return $fileName;
        }
        else {
            return null;
        }
    }

    function getTop(string $messenger): Collection {
        $top = [];
        $tops = ChannelsHasTop::all('top_id');
        foreach($tops as $t) {
            $top[] = $t->top_id;
        }
        $messenger = Messenger::where('name', $messenger)->first('id');
//->inRandomOrder()
        $topList = Top::with('channel')
            ->join('channels', 'channels.id', '=', 'top.channels_id')
            ->where('channels.messenger_id', $messenger->id)
            ->whereIn('top.id', $top)->get('top.*');
        $other = Top::with('channel')
            ->join('channels', 'channels.id', '=', 'top.channels_id')
            ->where('channels.messenger_id', $messenger->id)
            ->whereNotIn('top.id', $top)->get('top.*');
        return $topList->merge($other);
    }

    function getByCountry(int $countryId, string $messenger): Collection {
        $top = [];
        $tops = Country::with('topChannels')->where('id', $countryId)->first();
        foreach($tops->topChannels as $t) {
            $top[] = $t->id;
        }
        $messenger = Messenger::where('name', $messenger)->first('id');
        $topList = Channel::where('countries_id', $countryId)
            ->where('messenger_id', $messenger->id)
            ->whereIn('id', $top)->get();
        $other = Channel::where('countries_id', $countryId)
            ->where('messenger_id', $messenger->id)
            ->whereNotIn('id', $top)->get();
        return $topList->merge($other);
    }

    function getByCategory(int $categoryId, string $messenger): Collection {
        $top = [];
        $tops = Category::with('topChannels')->where('id', $categoryId)->first();
        foreach($tops->topChannels as $t) {
            $top[] = $t->id;
        }
        $messenger = Messenger::where('name', $messenger)->first('id');
        $topList = Channel::where('categories_id', $categoryId)
            ->where('messenger_id', $messenger->id)
            ->whereIn('id', $top)->get();
        $other = Channel::where('categories_id', $categoryId)
            ->where('messenger_id', $messenger->id)
            ->whereNotIn('id', $top)->get();
        return $topList->merge($other);
    }
}
