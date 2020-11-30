@extends("admin.template")

@section("title")
    @lang('pages.top_of_the_list_are_channels_by_category')
@endsection

@section("h3")
    <h3>@lang('pages.top_of_the_list_are_channels_by_category')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/topList.css')}}">

    <div class="top-list">
        <div>
            <div class="overflow-X-auto">
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
            <form action="{{ route('top-list-category-save') }}" method="POST" id="top-form">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">
                <input type="submit" value="@lang('pages.save')" class="button">
            </form>
        </div>
    </div>
@endsection
