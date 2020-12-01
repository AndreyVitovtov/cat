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
                <form action="{{ route('top-list-country', ['country' => 0]) }}" method="GET" id="form">
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

    <script>
        $('body').on('click', '.button', function(e) {
            e.preventDefault();
            let country = $('#select-country').val();
            let action = $('#form').attr('action');
            action = action.substring(0, action.length - 1)+country;
            $('#form').attr('action', action);
            $('#form').submit();
        });
    </script>
@endsection
