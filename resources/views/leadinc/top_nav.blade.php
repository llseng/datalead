
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
            <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>BD</strong></div>
        </a>
        <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
        </div>
        <!-- Navbar Menu -->
        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
        <!-- Search-->
        <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li>
        <!-- Logout    -->
        <li class="nav-item"><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link logout"> <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i></a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
        </ul>
    </div>
    </div>
</nav>
</header>