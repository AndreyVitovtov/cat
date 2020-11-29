@extends("admin.template")

@section("title")
    @lang('pages.channels_on_moderation')
@endsection

@section("h3")
    <h3>@lang('pages.channels_on_moderation')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/channels.css')}}">

    <div class="channels">
        <div>
            <div class="overflow-X-auto">
                <table>
                    <tr>
                        <td>№</td>
                        <td>@lang('pages.channel')</td>
                        <td>@lang('pages.country')</td>
                        <td>@lang('pages.category')</td>
                        <td>@lang('pages.actions')</td>
                    </tr>
                    @foreach($channels as $channel)
                        <form action="{{ route('channels-activate') }}" method="POST" id="form-activate-{{ $channel->id }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $channel->id }}">
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ $channel->link }}" target="_blank" class="link">{{ $channel->link }}</a>
                            </td>
                            <td>
                                <select name="country" id="country_{{ $channel->id }}">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="category" id="category_{{ $channel->id }}">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </form>
                            <td class="actions">
                                <div>
                                    <form>
                                        <button form="form-activate-{{ $channel->id }}">
                                            <i class='icon-play-1'></i>
                                        </button>
                                    </form>

{{--                                    <form action="{{ route('channels-edit') }}" method="POST" id="form-edit-{{ $channel->id }}">--}}
{{--                                        @csrf--}}
{{--                                        <input type="hidden" name="id" value="{{ $channel->id }}">--}}
{{--                                        <button form="form-edit-{{ $channel->id }}">--}}
{{--                                            <i class='icon-pen'></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}

                                    <form action="{{ route('channels-moderation-delete') }}" method="POST" id="form-delete-{{ $channel->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $channel->id }}">
                                        <button form="form-delete-{{ $channel->id }}">
                                            <i class='icon-trash-empty'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $channels->links() }}
        </div>
    </div>
@endsection
