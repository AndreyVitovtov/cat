@extends("admin.template")

@section("title")
    @lang('pages.channels')
@endsection

@section("h3")
    <h3>@lang('pages.channels')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/channels.css')}}">

    <div class="channels">
        <div>
            <div class="overflow-X-auto">
                <form action="{{ route('channels') }}" id="switch-messenger">
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
                        <td><input type="checkbox" name="check_all" id="check_all"></td>
                        <td>№</td>
                        <td>@lang('pages.channel')</td>
                        <td>@lang('pages.country')</td>
                        <td>@lang('pages.category')</td>
                        <td>@lang('pages.actions')</td>
                    </tr>
                    @foreach($channels as $channel)
                        <tr>
                            <td><input form="add_to_top" type="checkbox" name="channels[]" value="{{ $channel->id }}" class="checkbox"></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ $channel->link }}" class="link" target="_blank">{{ $channel->name }}</a>
                            </td>
                            <td>
                                {{ $channel->country->name }}
                            </td>
                            <td>
                                {{ $channel->category->name }}
                            </td>
                            <td class="actions">
                                <div>
                                    <form action="{{ route('channels-edit') }}" method="POST" id="form-edit-{{ $channel->id }}">
                                        @csrf
                                        <input type="hidden" name="messenger" value="{{ $messenger }}">
                                        <input type="hidden" name="id" value="{{ $channel->id }}">
                                        <button form="form-edit-{{ $channel->id }}">
                                            <i class='icon-pen'></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('channels-delete') }}" method="POST" id="form-delete-{{ $channel->id }}">
                                        @csrf
                                        <input type="hidden" name="messenger" value="{{ $messenger }}">
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
        <br>
        <div>
            <form action="{{ route('channels-add-top') }}" method="POST" id="add_to_top">
                @csrf
                <input type="hidden" name="messenger" value="{{ $messenger }}">
            </form>
            <button form="add_to_top" class="button">@lang('pages.add_to_top')</button>
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
