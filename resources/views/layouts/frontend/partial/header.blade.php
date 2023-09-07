<header>
    <div class="container-fluid position-relative no-side-padding">

        <a href="{{ url('/') }}" class="logo"><img src="{{ asset('frontend') }}/images/logo.png" alt="Logo Image"></a>

        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

        <ul class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{ url('/') }}">Home</a></li>
            @foreach($cms_pages as $cms)
            <li><a href="{{ route('cms', $cms->slug) }}">{{ $cms->title }}</a></li>
            @endforeach
            @if(Auth::check())
            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('user.logout') }}">Logout</a></li>
            @else
            <li><a href="{{ route('login') }}">Login</a></li>
            @endif
        </ul><!-- main-menu -->

{{--        <div class="src-area">--}}
{{--            <form>--}}
{{--                <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>--}}
{{--                <input class="src-input" type="text" placeholder="Type of search">--}}
{{--            </form>--}}
{{--        </div>--}}

    </div><!-- conatiner -->
</header>
