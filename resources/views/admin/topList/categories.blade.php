@extends("admin.template")

@section("title")
    @lang('pages.top_of_the_list_categories')
@endsection

@section("h3")
    <h3>@lang('pages.top_of_the_list_categories')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/topList.css')}}">

    <div class="top-list">
        <div>
            <div class="overflow-X-auto">
                <table>
                    <tr>
                        <td>№</td>
                        <td>@lang('pages.channel_name')</td>
                        <td>@lang('pages.actions')</td>
                    </tr>
{{--                    @foreach($tops as $tc)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $loop->iteration }}</td>--}}
{{--                            <td>--}}
{{--                                {{ $tc->channel->name }}--}}
{{--                            </td>--}}
{{--                            <td class="actions">--}}
{{--                                <div>--}}
{{--                                    <form action="{{ route('top-delete') }}" method="POST" id="form-delete-{{ $tc->id }}">--}}
{{--                                        @csrf--}}
{{--                                        <input type="hidden" name="id" value="{{ $tc->id }}">--}}
{{--                                        <button form="form-delete-{{ $tc->id }}">--}}
{{--                                            <i class='icon-trash-empty'></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
                </table>
            </div>
{{--            {{ $tops->links() }}--}}
        </div>
    </div>
@endsection
