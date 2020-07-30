
<!-- Main Navbar-->
<header class="header">
<nav class="navbar">
    <!-- Search Box-->
    <div class="search-box">
    <button class="dismiss"><i class="icon-close"></i></button>
    <form id="searchForm" action="#" role="search">
        <input type="search" placeholder="What are you looking for..." class="form-control">
    </form>
    </div>
    <div class="container-fluid">
    <div class="navbar-holder d-flex align-items-center justify-content-between">
        <!-- Navbar Header-->
        <div class="navbar-header">
        <!-- Navbar Brand -->
        <a href="index.html" class="navbar-brand d-none d-sm-inline-block">
            <div class="brand-text d-none d-lg-inline-block"><span>{{ config('app.name', 'Laravel') }} </span><strong>LS</strong></div>
            <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>DL</strong></div>
        </a>
        <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
        </div>
        <!-- Navbar Menu -->
        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
        <!-- Search-->
        <li class="nav-item d-flex align-items-center"><a id="search" href="#" class="nav-link" ><i class="icon-search"></i></a></li>
        <!-- applist -->
        <li class="nav-item d-flex align-items-center"><a href="{{ route('game') }}" class="nav-link"><i class="icon-list"></i></a></li>

        @if( session()->has( 'gameapp.key' ) )
        <!-- app dropdown -->
        <li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><i class="icon-bill"></i><span class="d-none d-sm-inline-block">{{ session()->get( 'gameapp.val' ) }}</span></a>
            <ul aria-labelledby="languages" class="dropdown-menu">
                @foreach( session()->get( 'gameapp.list' ) as $app_k => $app_v )
                <li class="{{ session()->get( 'gameapp.key' ) == $app_k ? 'dropdown-header': '' }}">
                    <a rel="nofollow" href="{{ session()->get( 'gameapp.key' ) == $app_k ? 'javascript:void(0);': route('game_select', ['id' => $app_k]) }}" class="dropdown-item">{{ $app_v }}</a>
                </li>
                @endforeach
            </ul>
        </li>
        @endif

        <!-- Logout    -->
        <li class="nav-item"><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link logout"> <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i></a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
        </ul>
    </div>
    </div>
</nav>
</header>