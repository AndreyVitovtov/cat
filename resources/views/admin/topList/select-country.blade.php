@extends("admin.template")

@section("title")
    @lang('pages.top_of_the_list_are_channels_by_country')
@endsection

@section("h3")
    <h3>@lang('pages.top_of_the_list_are_channels_by_country')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/topList.css')}}">

    <div class="top-list">
        <div>
            <div class="overflow-X-auto">
                <form action="{{ route('top-list-country') }}" method="GET">
                    <div>
                        <label for="select-country">@lang('pages.select_country')</label>
                        <select name="country" id="select-country">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div>
                        <input type="submit" value="@lang('pages.go')" class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
