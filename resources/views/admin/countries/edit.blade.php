@extends("admin.template")

@section("title")
    @lang('pages.countries_edit')
@endsection

@section("h3")
    <h3>@lang('pages.countries_edit')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/countries.css')}}">

    <form action="{{ route('countries-edit-save') }}" method="POST">
        <input type="hidden" name="id" value="{{ $country->id }}">
        @csrf
        <div>
            <label for="name">@lang('pages.countries_name')</label>
            <input type="text" name="name" id="name" value="{{ $country->name }}" autofocus>
        </div>
        <br>
        <div>
            <input type="submit" value="@lang('pages.save')" class="button">
        </div>
    </form>
@endsection


