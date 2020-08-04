
<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <a href="#">
                <img src="{{ asset('/') }}img/avatar.jpg" alt="..." class="img-fluid rounded-circle">
            </a>
        </div>
        <div class="title">
            <h1 class="h4">{{ Auth::user()->name }}</h1>
            <p>{{ Auth::user()->name }}</p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="@if(isset($left_nav_name) && $left_nav_name == 'home') active @endif">
            <a href="{{ route('home') }}"> <i class="icon-home"></i>总览</a>
        </li>
        <li class="@if(isset($left_nav_name) && $left_nav_name == 'tables') active @endif">
            <a href="tables.html"><i class="fa fa-bar-chart"></i>实时</a>
        </li>
        <li class="@if(isset($left_nav_name) && $left_nav_name == 'charts') active @endif">
            <a href="charts.html"> <i class="icon-grid"></i>对比</a>
        </li>
    </ul>
    <span class="heading">EXTRAS</span>
    <ul class="list-unstyled">
        <li class="@if(isset($left_nav_name) && $left_nav_name == 'game') active @endif">
            <a href="{{ route('game') }}"> <i class="icon-list"></i>应用管理</a>
        </li>
    </ul>
</nav>