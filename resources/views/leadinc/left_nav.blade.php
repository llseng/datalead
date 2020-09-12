
<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <a href="{{ route('user') }}">
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
        <li>
            <a href="#log-stream" @if(isset($left_nav_name) && $left_nav_name == 'log_stream') aria-expanded="true" @else aria-expanded="false" @endif data-toggle="collapse" class="@if(isset($left_nav_name) && $left_nav_name != 'log_stream') collapsed @endif">
                <i class="icon-grid"></i>日志流
            </a>
            <ul id="log-stream" class="collapse list-unstyled @if(isset($left_nav_name) && $left_nav_name == 'log_stream') show @endif">
                <li class="@if(isset($left_nav_li_name) && $left_nav_li_name == 'log_stream_byteshow') active @endif">
                    <a href="{{ route('log_stream_byteshow') }}">字节广告展示</a>
                </li>
                <li class="@if(isset($left_nav_li_name) && $left_nav_li_name == 'log_stream_byteclick') active @endif">
                    <a href="{{ route('log_stream_byteclick') }}">字节广告点击</a>
                </li>
                <li class="@if(isset($left_nav_li_name) && $left_nav_li_name == 'log_stream_inits') active @endif">
                    <a href="{{ route('log_stream_inits') }}">应用启动</a>
                </li>
                <li class="@if(isset($left_nav_li_name) && $left_nav_li_name == 'log_stream_users') active @endif">
                    <a href="{{ route('log_stream_users') }}">应用激活</a>
                </li>
            </ul>
        </li>
    </ul>
    <span class="heading">EXTRAS</span>
    <ul class="list-unstyled">
        <li class="@if(isset($left_nav_name) && $left_nav_name == 'game') active @endif">
            <a href="{{ route('game') }}"> <i class="icon-list"></i>应用管理</a>
        </li>
        <li class="@if(isset($left_nav_name) && $left_nav_name == 'callback') active @endif">
            <a href="{{ route('callback') }}"> <i class="icon-paper-airplane"></i>回调管理</a>
        </li>
    </ul>
</nav>