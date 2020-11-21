<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") | @lang('template.title')</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/developer.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontello.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon">
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/admin-panel/common.js')}}"></script>
    <script src="{{asset('js/admin-panel/drawChart.js')}}"></script>
    <script src="{{asset('https://www.gstatic.com/charts/loader.js')}}"></script>
</head>
<body>
<div class="pop-up-window">
</div>
<header>
    <section class="left-panel">
        @lang('template.left_panel_panel')
    </section>
    <section class="right-panel">
        <nav class="open-menu mob-hidden">
            <i class="icon-menu"></i>
        </nav>
        <nav class="open-menu-mob pc-hidden">
            <i class="icon-menu"></i>
        </nav>
        <div class="right-panel-lang-user">
            <div class="languages">
                <div>
                    <a href="{{ route('locale', App::getLocale()) }}">
                        <img src="{{ url('/img/language/'.App::getLocale().'.png') }}" alt="">
                    </a>
                </div>
                <div class="languages-other">
                    @if(App::getLocale() == "ru")
                        <a href="{{ route('locale', 'us') }}">
                            <img src="{{ url('/img/language/us.png') }}" alt="">
                        </a>
                    @else
                        <a href="{{ route('locale', 'ru') }}">
                            <img src="{{ url('/img/language/ru.png') }}" alt="">
                        </a>
                    @endif
                </div>
            </div>
            <nav class="open-user-menu">
                <img src="{{asset('img/avatar5.png')}}" alt="avatar">
                <span>
                @lang('template.left_panel_administrator')
            </span>
            </nav>
        </div>
        <div class="dropdown-menu">
            <img src="{{asset('img/avatar5.png')}}" alt="avatar">
            <div class="title">
                <div>
                    @lang('template.top_panel_administrator')
                </div>
                <div>
                    {{ Auth::user()->name }}
                </div>
            </div>
            <div class="dropdown-menu-nav">
                <div>
                    <form action="/admin/settings" method="POST">
                        @csrf
                        <button class="button user-settings">@lang('template.top_panel_settings')</button>
                    </form>
                </div>
                <div>
                    <form action="/logout">
                        <button data-go="exit" class="button">@lang('template.top_panel_log_off')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</header>
<main>
    <section class="sidebar no-active">
        <div class="user-panel">
            <img src="{{asset('img/avatar5.png')}}" alt="avatar">
            <span>
                @lang('template.left_panel_administrator')
            </span>
        </div>
        <ul class="sidebar-menu">
            <li class="header">@lang('template.left_panel_menu')</li>
            @include('admin.menu')
        </ul>
    </section>
    <section class="content">
        <div class="container">
            @yield("h3")
            <div>
                @yield("main")
            </div>
        </div>
        <footer>
            Copyright © 2020 <a href="https://vitovtov.top" target="_blank">vitovtov.top</a>
        </footer>
    </section>
</main>

@if(isset($menuItem))
    <script>
        $('.item-menu').removeClass('active');
        $('main section.sidebar .menu-hidden div').removeClass('active');
        $('.{{ $menuItem }}').addClass('active');
        $('.{{ $menuItem }}').parents('span.rolled-hidden').children('li.item-menu').addClass('active');
        $('.{{ $menuItem }}').parents('li').addClass('menu-active');
        $('.{{ $menuItem }}').parents('li').toggle();
    </script>
@endif

@if(isset($notification))
    <script>
        setTimeout(function() {
            popUpWindow({{ $notification }})
        }, 300);
    </script>
@endif
</body>
</html>

