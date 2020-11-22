@extends("admin.template")

@section("title")
    @lang('pages.categories_edit')
@endsection

@section("h3")
    <h3>@lang('pages.categories_edit')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/categories.css')}}">

    <form action="{{ route('categories-edit-save') }}" method="POST">
        <input type="hidden" name="id" value="{{ $category->id }}">
        @csrf
        <div>
            <label for="name">@lang('pages.categories_name')</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" autofocus>
        </div>
        <br>
        <div>
            <input type="submit" value="@lang('pages.save')" class="button">
        </div>
    </form>
@endsection


