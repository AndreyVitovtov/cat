@extends("admin.template")

@section("title")
    @lang('pages.countries_add')
@endsection

@section("h3")
    <h3>@lang('pages.countries_add')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/countries.css')}}">

    <form action="{{ route('countries-add-save') }}" method="POST">
        @csrf
        <div>
            <label for="name">@lang('pages.countries-name')</label>
            <input type="text" name="name" id="name">
        </div>
        <br>
        <div>
            <input type="checkbox" name="more" id="add_more">
             - <label for="add_more">@lang('pages.add_more')</label>
        </div>
        <br>
        <div>
            <input type="submit" value="@lang('pages.add')" class="button">
        </div>
    </form>
@endsection


