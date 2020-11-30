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
                <form action="{{ route('top-list-category') }}" method="GET">
                    <div>
                        <label for="select-category">@lang('pages.select_category')</label>
                        <select name="category" id="select-category">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
