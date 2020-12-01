@extends("admin.template")

@section("title")
    @lang('pages.top_of_the_list_are_channels_by_country')
@endsection

@section("h3")
    <h3>@lang('pages.top_of_the_list_are_channels_by_country') <b>({{ $countryName->name }})</b></h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/topList.css')}}">

    <div class="top-list">
        <div>
            <div class="overflow-X-auto">
                <form action="{{ route('top-list-country', ['country' => $country]) }}" id="switch-messenger">
                </form>
                <div class="switch">
                    <input type="radio" name="switch-messenger" value="Telegram" id="telegram" class="telegram hidden"
                           onchange="sendForm()"
                           @if($messenger == 'Telegram')
                           checked
                        @endif
                    >
                    <input type="radio" name="switch-messenger" value="Viber" id="viber" class="viber hidden"
                           onchange="sendForm()"
                           @if($messenger == 'Viber')
                           checked
                        @endif
                    >
                    <span class="left">
                        <label for="viber">
                            Viber
                        </label>
                    </span>
                    <span class="right">
                        <label for="telegram">
                            Telegram
                        </label>
                    </span>
                </div>
                <br>
                <table>
                    <tr>
                        <td>@lang('pages.top')</td>
                        <td>№</td>
                        <td>@lang('pages.channel')</td>
                    </tr>
                    @foreach($channels as $channel)
                        <tr>
                            <td>
                                <input type="checkbox" name="channel[]" form="top-form" value="{{ $channel->id }}"
                                       @if(in_array($channel->id, $top))
                                       checked
                                    @endif
                                >
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ $channel->link }}" class="link" target="_blank">{{ $channel->name }}</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <br>
        <div>
            <form action="{{ route('top-list-country-save') }}" method="POST" id="top-form">
                @csrf
                <input type="hidden" name="country" value="{{ $country }}">
                <input type="hidden" name="messenger" value="{{ $messenger }}">
                <input type="submit" value="@lang('pages.save')" class="button">
            </form>
        </div>
    </div>

    <script>
        function sendForm() {
            let value = $('input[name=switch-messenger]:checked').val();
            let action = $('#switch-messenger').attr('action')+"/"+value;
            $('#switch-messenger').attr('action', action);
            $('#switch-messenger').submit();
        }
    </script>
@endsection
