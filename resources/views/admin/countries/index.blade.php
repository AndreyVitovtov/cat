@extends("admin.template")

@section("title")
    @lang('pages.countries')
@endsection

@section("h3")
    <h3>@lang('pages.countries')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/countries.css')}}">

    <div class="countries">
        <div>
            <div class="overflow-X-auto">
                <table>
                    <tr>
                        <td>№</td>
                        <td>@lang('pages.country')</td>
                        <td>@lang('pages.actions')</td>
                    </tr>
                    @foreach($countries as $country)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $country->name }}
                            </td>
                            <td class="actions">
                                <div>
                                    <form action="{{ route('countries-edit') }}" method="POST" id="form-edit-{{ $country->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $country->id }}">
                                        <button form="form-edit-{{ $country->id }}">
                                            <i class='icon-pen'></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('countries-delete') }}" method="POST" id="form-delete-{{ $country->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $country->id }}">
                                        <button form="form-delete-{{ $country->id }}">
                                            <i class='icon-trash-empty'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $countries->links() }}
        </div>
    </div>
@endsection
