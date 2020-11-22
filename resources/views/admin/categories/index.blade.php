@extends("admin.template")

@section("title")
    @lang('pages.categories')
@endsection

@section("h3")
    <h3>@lang('pages.categories')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/categories.css')}}">

    <div class="categories">
        <div>
            <div class="overflow-X-auto">
                <table>
                    <tr>
                        <td>№</td>
                        <td>@lang('pages.category')</td>
                        <td>@lang('pages.actions')</td>
                    </tr>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $category->name }}
                            </td>
                            <td class="actions">
                                <div>
                                    <form action="{{ route('categories-edit') }}" method="POST" id="form-edit-{{ $category->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $category->id }}">
                                        <button form="form-edit-{{ $category->id }}">
                                            <i class='icon-pen'></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('categories-delete') }}" method="POST" id="form-delete-{{ $category->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $category->id }}">
                                        <button form="form-delete-{{ $category->id }}">
                                            <i class='icon-trash-empty'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
