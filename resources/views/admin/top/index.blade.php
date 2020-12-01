@extends("admin.template")

@section("title")
    @lang('pages.top_channels')
@endsection

@section("h3")
    <h3>@lang('pages.top_channels')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/top.css')}}">

    <div class="top">
        <div>
            <div class="overflow-X-auto">
                <form action="{{ route('channels-top') }}" id="switch-messenger">
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
                        <td>№</td>
                        <td>@lang('pages.channel')</td>
                        <td>@lang('pages.actions')</td>
                    </tr>
                    @foreach($tops as $tc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ $tc->channel->link }}" class="link">{{ $tc->channel->name }}</a>
                            </td>
                            <td class="actions">
                                <div>
                                    <form action="{{ route('channels-top-delete') }}" method="POST" id="form-delete-{{ $tc->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $tc->id }}">
                                        <input type="hidden" name="messenger" value="{{ $messenger }}">
                                        <button form="form-delete-{{ $tc->id }}">
                                            <i class='icon-trash-empty'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
{{--            {{ $tops->links() }}--}}
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
