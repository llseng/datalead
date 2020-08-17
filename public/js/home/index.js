$(document).ready( function() {

    'use strict'; //开启严格模式

    $("#home-date-range").datepicker({
        format: "yyyy-mm-dd",
        language: "zh-CN",
        todayBtn: true,
        todayHighlight: true,
        showMeridian: 1,
        pickerPosition: "bottom-left",
        startDate:new Date(new Date()-1000 * 60 * 60 * 24 * 365),  //只显示一年的日期365天
        endDate : new Date()
    }); //时间范围

    //时间范围快捷按钮
    $("#home-date-btn .btn").click( function() {
        $("#home-date-btn .btn").removeClass( "active" );
        var $this = $(this);
        var $this_strat_date_change = $this.attr("data-start-date-change");
        var $this_end_date_change = $this.attr("data-end-date-change");

        var start_date_change = $this_strat_date_change? parseInt( $this_strat_date_change ): 0;
        var end_date_change = $this_end_date_change? parseInt( $this_end_date_change ): 0;

        var day_mtime = 60 * 60 * 24 * 1000;
        var start_date = new Date();
        var end_date = new Date();
        var time;
        
        if( start_date_change != 0 ) {
            time = start_date.getTime();
            start_date.setTime( time + start_date_change * day_mtime );
        }
        if( end_date_change != 0 ) {
            time = end_date.getTime();
            end_date.setTime( time + end_date_change * day_mtime );
        }

        $("#date_start").datepicker("setDate", start_date.format("yyyy-MM-dd"));
        $("#date_end").datepicker("setDate", end_date.format("yyyy-MM-dd"));

        $this.addClass( "active" );
    });

    //数据刷新按钮
    $("#home-date-submit .btn-success").click( function (){
        $(".card-close .refresh").trigger("click");
    });

    //点击数据折线图
    var clickLineChartDom = $("#clickLine .card-body").get(0);
    var clickLineChart = echarts.init( clickLineChartDom, "light", { height: parseInt( (clickLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function clickLineChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: ["点击"]
            },
            yAxis: {},
            xAxis: {
                data: [1,2,3,4,5,6]
            },
            series: [{
                name: "点击",
                type: "line",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            }]
        };
        clickLineChart.setOption( option );
    }
    $("#clickLine .card-close .refresh").click( function () {
        clickLineChartRefresh();
    } );

    //启动数据折线图
    var initLineChartDom = $("#initLine .card-body").get(0);
    var initLineChart = echarts.init( initLineChartDom, "light", { height: parseInt( (initLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function initLineChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: ["启动"]
            },
            yAxis: {},
            xAxis: {
                data: [1,2,3,4,5,6]
            },
            series: [{
                name: "启动",
                type: "line",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            }]
        };
        initLineChart.setOption( option );
    }
    $("#initLine .card-close .refresh").click( function () {
        initLineChartRefresh();
    } );

    //激活数据折线图
    var activationLineChartDom = $("#activationLine .card-body").get(0);
    var activationLineChart = echarts.init( activationLineChartDom, "light", { height: parseInt( (activationLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function activationLineChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: ["自然", "字节跳动"]
            },
            yAxis: {},
            xAxis: {
                data: [1,2,3,4,5,6]
            },
            series: [{
                name: "自然",
                type: "line",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            },
            {
                name: "字节跳动",
                type: "line",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            }]
        };
        activationLineChart.setOption( option );
    }
    $("#activationLine .card-close .refresh").click( function () {
        activationLineChartRefresh();
    } );

    //活跃数据折线图
    var activeLineChartDom = $("#activeLine .card-body").get(0);
    var activeLineChart = echarts.init( activeLineChartDom, "light", { height: parseInt( (activeLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function activeLineChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: ["自然", "字节跳动"]
            },
            yAxis: {},
            xAxis: {
                data: [1,2,3,4,5,6]
            },
            series: [{
                name: "自然",
                type: "line",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            },
            {
                name: "字节跳动",
                type: "line",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            }]
        };
        activeLineChart.setOption( option );
    }
    $("#activeLine .card-close .refresh").click( function () {
        activeLineChartRefresh();
    } );

    //次留数据折线图
    var oneRetainedLineChartDom = $("#oneRetainedLine .card-body").get(0);
    var oneRetainedLineChart = echarts.init( oneRetainedLineChartDom, "light", { height: parseInt( (oneRetainedLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function oneRetainedLineChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: ["自然", "字节跳动"]
            },
            yAxis: {},
            xAxis: {
                data: [1,2,3,4,5,6]
            },
            series: [{
                name: "自然",
                type: "bar",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            },
            {
                name: "字节跳动",
                type: "bar",
                data: [ parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ) ]
            }]
        };
        oneRetainedLineChart.setOption( option );
    }
    $("#oneRetainedLine .card-close .refresh").click( function () {
        oneRetainedLineChartRefresh();
    } );
    
    //次留渠道数据饼图
    var oneRetainedChannelBarChartDom = $("#oneRetainedChannelBar .card-body").get(0);
    var oneRetainedChannelBarChart = echarts.init( oneRetainedChannelBarChartDom, "light", { height: parseInt( (oneRetainedChannelBarChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function oneRetainedChannelBarChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data:['自然', "字节跳动"]
            },
            xAxis: {
                data: [1,2,3,4,5,6]
            },
            yAxis: {},
            series: [{
                name: '自然',
                type: 'bar',
                data: [parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 )]
            },
            {
                name: '字节跳动',
                type: 'bar',
                data: [parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 ), parseInt( Math.random() * 100 )]
            }]
        };

        oneRetainedChannelBarChart.setOption( option );
    }
    $("#oneRetainedChannelBar .card-close .refresh").click( function () {
        oneRetainedChannelBarChartRefresh();
    } );

    //渠道数据饼图
    var channelPieChartDom = $("#channelPie .card-body").get(0);
    var channelPieChart = echarts.init( channelPieChartDom, "light", { height: parseInt( (channelPieChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function channelPieChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: ["自然", "字节跳动"]
            },
            series: [{
                name: "渠道",
                type: "pie",
                data: [
                    {value: parseInt( Math.random() * 100 ), name: "自然"},
                    {value: parseInt( Math.random() * 100 ), name: "字节跳动"},
                ]
            }]
        };
        channelPieChart.setOption( option );
    }
    $("#channelPie .card-close .refresh").click( function () {
        channelPieChartRefresh();
    } );

    //点击投放数据饼图
    var clickTypePieChartDom = $("#clickTypePie .card-body").get(0);
    var clickTypePieChart = echarts.init( clickTypePieChartDom, "light", { height: parseInt( (clickTypePieChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function clickTypePieChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: ["今日头条","西瓜视频","火山小视频","抖音","穿山甲开屏广告","穿山甲网盟非开屏广告"]
            },
            series: [{
                name: "点击投放",
                type: "pie",
                data: [
                    {value: parseInt( Math.random() * 100 ), name: "今日头条"},
                    {value: parseInt( Math.random() * 100 ), name: "西瓜视频"},
                    {value: parseInt( Math.random() * 100 ), name: "火山小视频"},
                    {value: parseInt( Math.random() * 100 ), name: "抖音"},
                    {value: parseInt( Math.random() * 100 ), name: "穿山甲开屏广告"},
                    {value: parseInt( Math.random() * 100 ), name: "穿山甲网盟非开屏广告"},
                ]
            }]
        };
        clickTypePieChart.setOption( option );
    }
    $("#clickTypePie .card-close .refresh").click( function () {
        clickTypePieChartRefresh();
    } );

    //点击样式数据饼图
    var clickSitePieChartDom = $("#clickSitePie .card-body").get(0);
    var clickSitePieChart = echarts.init( clickSitePieChartDom, "light", { height: parseInt( (clickSitePieChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function clickSitePieChartRefresh( ) {
        var option = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: ["小图模式","大图模式","组图模式","视频"]
            },
            series: [{
                name: "点击样式",
                type: "pie",
                data: [
                    {value: parseInt( Math.random() * 100 ), name: "小图模式"},
                    {value: parseInt( Math.random() * 100 ), name: "大图模式"},
                    {value: parseInt( Math.random() * 100 ), name: "组图模式"},
                    {value: parseInt( Math.random() * 100 ), name: "视频"}
                ]
            }]
        };
        clickSitePieChart.setOption( option );
    }
    $("#clickSitePie .card-close .refresh").click( function () {
        clickSitePieChartRefresh();
    } );

    //刷新图表
    function echartsResize() {
        //点击数据折线图
        clickLineChart.resize({ height: parseInt( (clickLineChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //启动数据折线图
        initLineChart.resize({ height: parseInt( (initLineChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //激活数据折线图
        activationLineChart.resize({ height: parseInt( (activationLineChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //活跃数据折线图
        activeLineChart.resize({ height: parseInt( (activeLineChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //次留数据折线图
        oneRetainedLineChart.resize({ height: parseInt( (oneRetainedLineChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //次留渠道数据饼图
        oneRetainedChannelBarChart.resize({ height: parseInt( (oneRetainedChannelBarChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //渠道数据饼图
        channelPieChart.resize({ height: parseInt( (channelPieChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //点击投放数据饼图
        clickTypePieChart.resize({ height: parseInt( (clickTypePieChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //点击样式数据饼图
        clickSitePieChart.resize({ height: parseInt( (clickSitePieChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
    }

    window.addEventListener('resize', function() {
        if( this.echarts_resize_tout ) {
            clearTimeout( this.echarts_resize_tout );
        }
        //刷新图表定时器
        this.echarts_resize_tout = setTimeout( echartsResize, 500 );
    });

    /**
     * 以上为定义代码
     * 以下为过程代码
     */

    //刷新
    $("#home-date-btn .btn").eq(0).trigger('click');
    //刷新
    $("#home-date-submit .btn-success").trigger('click');

} );