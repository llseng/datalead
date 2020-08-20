@extends('layouts.base')

@section('other_source')
    @include('leadinc.echarts_js')
    @include('leadinc.bootstrap_datepicker_js')
    @if( env("APP_DEBUG", false) )
    <script src="{{ asset('/') }}js/home/index.js?{{ time() }}" ></script>
    @else
    <script src="{{ asset('/') }}js/home/index.js" ></script>
    @endif
@endsection

@section('content')
<!-- 数据量总数 -->
<section class="dashboard-counts no-padding-bottom">
<div class="container-fluid">
    <div class="row bg-white has-shadow">
    <!-- Item -->
    <div class="col-xl-3 col-sm-6">
        <div class="item d-flex align-items-center">
        <div class="icon bg-violet">
            <i class="icon-screen"></i>
        </div>
        <div class="title">
            <span>总<br>展示</span>
        </div>
        <div class="number">
            <strong>{{ $count['total_show'] }}</strong>
        </div>
        </div>
    </div>
    <!-- Item -->
    <div class="col-xl-3 col-sm-6">
        <div class="item d-flex align-items-center">
        <div class="icon bg-red">
            <i class="icon-website"></i>
        </div>
        <div class="title">
            <span>总<br>点击</span>
        </div>
        <div class="number">
            <strong>{{ $count['total_click'] }}</strong>
        </div>
        </div>
    </div>
    <!-- Item -->
    <div class="col-xl-3 col-sm-6">
        <div class="item d-flex align-items-center">
        <div class="icon bg-green">
            <i class="icon-interface-windows"></i>
        </div>
        <div class="title">
            <span>总<br>启动</span>
        </div>
        <div class="number">
            <strong>{{ $count['total_init'] }}</strong>
        </div>
        </div>
    </div>
    <!-- Item -->
    <div class="col-xl-3 col-sm-6">
        <div class="item d-flex align-items-center">
        <div class="icon bg-orange">
            <i class="icon-user"></i>
        </div>
        <div class="title">
            <span>总<br>激活</span>
        </div>
        <div class="number">
            <strong>{{ $count['total_users'] }}</strong>
        </div>
        </div>
    </div>
    </div>
</div>
</section>
<!-- 时间范围 -->
<section class="forms no-padding-bottom"> 
<div class="container-fluid">
    <div class="row">
        <!-- Inline Form-->
        <div class="col-lg-12">                           
            <div class="card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard3" class="dropdown-menu dropdown-menu-right has-shadow"><a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">时间范围</h3>
            </div>
            <div class="card-body">
                <form id="home-date-form" class="form-inline">
                    
                    <div id="home-date-btn" class="form-group">
                        <button type="button" class="btn btn-light mr-3">今天</button>
                        <button type="button" class="btn btn-light mr-3" data-start-date-change="-1" data-end-date-change="-1">昨天</button>
                        <button type="button" class="btn btn-light mr-3" data-start-date-change="-7" data-end-date-change="-1">近7天</button>
                        <button type="button" class="btn btn-light mr-3" data-start-date-change="-30" data-end-date-change="-1">近30天</button>
                    </div>
                    <div id="home-date-range" class="form-group input-group input-daterange">
                        <input id="date_start" name="date_start" type="text" placeholder="开始日期" class="mr-3 form-control">
                        <input id="date_end" name="date_end" type="text" placeholder="结束日期" class="mr-3 form-control">
                    </div>
                    <div id="home-date-submit" class="form-group">
                        <button type="button" class="btn btn-success">刷新</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
</section>
<!-- 图表 -->
<section class="charts no-padding-top">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">数据总览</h3>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- 展示 -->
        <!-- <div class="col-lg-6">
            <div class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">展示</h3>
            </div>
            <div class="card-body">
                <canvas id="showLine"></canvas>
            </div>
            </div>
        </div> -->
        <!-- 点击 -->
        <div class="col-lg-6">
            <div id="clickLine" data-api-url="{{ route('home_chart_byte_click', ['app_id' => $app_id]) }}" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">点击</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
        <!-- 启动 -->
        <div class="col-lg-6">
            <div id="initLine" data-api-url="{{ route('home_chart_app_init', ['app_id' => $app_id]) }}" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">启动</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
        <!-- 激活 -->
        <div class="col-lg-6">
            <div id="activationLine" data-api-url="{{ route('home_chart_activation', ['app_id' => $app_id]) }}" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">激活</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
        <!-- 活跃 -->
        <div class="col-lg-6">
            <div id="activeLine" data-api-url="{{ route('home_chart_active', ['app_id' => $app_id]) }}" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">活跃</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">留存数据</h3>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- 次留 -->
        <div class="col-lg-6">
            <div id="oneRetainedLine" data-api-url="{{ route('home_chart_oneRetained', ['app_id' => $app_id]) }}" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">次留</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
        <!-- 次留渠道 -->
        <div class="col-lg-6">
            <div id="oneRetainedChannelBar" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">次留渠道</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">数据对比</h3>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- 渠道 -->
        <div class="col-lg-4">
            <div id="channelPie" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">渠道</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
        <!-- 点击投放 -->
        <div class="col-lg-4">
            <div id="clickTypePie" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">点击投放</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
        <!-- 点击样式 -->
        <div class="col-lg-4">
            <div id="clickSitePie" class="line-chart-example card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="javascript:void(0);" class="dropdown-item refresh"> <i class="fa fa-refresh"></i>refresh</a>
                    <a href="javascript:void(0);" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
                </div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">点击样式</h3>
            </div>
            <div class="card-body">
                <canvas></canvas>
            </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
