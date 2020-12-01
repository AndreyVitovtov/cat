@extends("admin.template")

@section("title")
    @lang('pages.channels_edit')
@endsection

@section("h3")
    <h3>@lang('pages.channels_edit')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/channels.css')}}">

    <div class="channels">
        <div>
            <form action="{{ route('channels-edit-save') }}" method="POST">
                @csrf
                <input type="hidden" name="messenger" value="{{ $messenger }}">
                <input type="hidden" name="id" value="{{ $channel->id }}">
                <div>
                    <label for="name">@lang('pages.channel')</label>
                    <input type="text" name="name" id="name" value="{{ $channel->name }}">
                </div>
                <div>
                    <label for="country">@lang('pages.country')</label>
                    <select name="country" id="country">
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                @if($channel->countries_id == $country->id)
                                    selected
                                @endif
                            >{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="category">@lang('pages.category')</label>
                    <select name="category" id="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @if($channel->categories_id == $category->id)
                                    selected
                                @endif
                            >{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div>
                    <input type="submit" value="@lang('pages.save')" class="button">
                </div>
            </form>
        </div>
    </div>
@endsection
