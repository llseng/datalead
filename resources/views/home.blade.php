@extends('layouts.base')

@section('other_source')
    @include('leadinc.chart_js')
    @include('leadinc.bootstrap_datepicker_js')
    <script src="{{ asset('/') }}js/home/index.js" ></script>
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
            <strong>25</strong>
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
            <strong>70</strong>
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
            <strong>40</strong>
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
            <strong>50</strong>
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
                        <input id="date_start" type="text" placeholder="开始日期" class="mr-3 form-control">
                        <input id="date_end" type="text" placeholder="结束日期" class="mr-3 form-control">
                    </div>
                    <div id="home-date-submit" class="form-group">
                        <button type="button" class="btn btn-success">确定</button>
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
                <canvas id="showLineChart"></canvas>
            </div>
            </div>
        </div> -->
        <!-- 点击 -->
        <div class="col-lg-6">
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
                <h3 class="h4">点击</h3>
            </div>
            <div class="card-body">
                <canvas id="clickLineChart"></canvas>
            </div>
            </div>
        </div>
        <!-- 启动 -->
        <div class="col-lg-6">
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
                <h3 class="h4">启动</h3>
            </div>
            <div class="card-body">
                <canvas id="initLineChart"></canvas>
            </div>
            </div>
        </div>
        <!-- 激活 -->
        <div class="col-lg-6">
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
                <h3 class="h4">激活</h3>
            </div>
            <div class="card-body">
                <canvas id="activationLineChart"></canvas>
            </div>
            </div>
        </div>
        <!-- 活跃 -->
        <div class="col-lg-6">
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
                <h3 class="h4">活跃</h3>
            </div>
            <div class="card-body">
                <canvas id="activeLineChart"></canvas>
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
        <div class="col-lg-8">
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
                <h3 class="h4">次留</h3>
            </div>
            <div class="card-body">
                <canvas id="oneRetainedLineChart"></canvas>
            </div>
            </div>
        </div>
        <!-- 次留渠道 -->
        <div class="col-lg-4">
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
                <h3 class="h4">次留渠道</h3>
            </div>
            <div class="card-body">
                <canvas id="oneRetainedChannelBarChart"></canvas>
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
                <h3 class="h4">渠道</h3>
            </div>
            <div class="card-body">
                <canvas id="channelPieChart"></canvas>
            </div>
            </div>
        </div>
        <!-- 点击投放 -->
        <div class="col-lg-4">
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
                <h3 class="h4">点击投放</h3>
            </div>
            <div class="card-body">
                <canvas id="clickTypePieChart"></canvas>
            </div>
            </div>
        </div>
        <!-- 点击样式 -->
        <div class="col-lg-4">
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
                <h3 class="h4">点击样式</h3>
            </div>
            <div class="card-body">
                <canvas id="clickSitePieChart"></canvas>
            </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
