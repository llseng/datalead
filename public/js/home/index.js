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
    $("#home-date-range").datepicker().on("changeDate", function(e){
        $("#home-date-btn .btn").removeClass( "active" );
    } );

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

    var homeDateFormDom = $("#home-date-form").get(0);
    //获取时间范围formData
    function getHomeDateFormData() {
        return new FormData( homeDateFormDom );
    }

    //点击数据折线图
    var clickLineChartDom = $("#clickLine .card-body").get(0);
    var clickLineChart = echarts.init( clickLineChartDom, "light", { height: parseInt( (clickLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function clickLineChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }

        var legendData = [];
        var xAxisData = [];
        var xAxisS = true;
        var series_list = [];

        for (var x in resData) {
            var series_li_data = [];
            for ( var y in resData[x] ) {
                if( xAxisS ) xAxisData.push( resData[x][y].date );
                series_li_data.push( resData[x][y].num );
            }
            var name = x + "( "+ arrayNumberSum( series_li_data ) +" )";
            legendData.push( name );
            if( xAxisS ) xAxisS = false;
            var series_li = {type: "line"};
            series_li.name = name;
            series_li.data = [].concat( series_li_data ); //拷贝
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: legendData
            },
            yAxis: {},
            xAxis: {
                data: xAxisData
            },
            series: series_list
        };
        clickLineChart.setOption( option );
    }
    var clickLineChartApiUrl = $("#clickLine").attr("data-api-url");
    var clickLineChartStatus = false;
    $("#clickLine .card-close .refresh").click( function () {
        var alert_title = "<b>-点击数据-</b>";
        if( !clickLineChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( clickLineChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        clickLineChartStatus = true;

        var reqUrl = clickLineChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                clickLineChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                clickLineChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                clickLineChartRefresh( resData );
            }
        });
    } );

    //启动数据折线图
    var initLineChartDom = $("#initLine .card-body").get(0);
    var initLineChart = echarts.init( initLineChartDom, "light", { height: parseInt( (initLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function initLineChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }

        var legendData = [];
        var xAxisData = [];
        var xAxisS = true;
        var series_list = [];

        for (var x in resData) {
            var series_li_data = [];
            for ( var y in resData[x] ) {
                if( xAxisS ) xAxisData.push( resData[x][y].date );
                series_li_data.push( resData[x][y].num );
            }
            var name = x + "( "+ arrayNumberSum( series_li_data ) +" )";
            legendData.push( name );
            if( xAxisS ) xAxisS = false;
            var series_li = {type: "line"};
            series_li.name = name;
            series_li.data = [].concat( series_li_data ); //拷贝
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: legendData
            },
            yAxis: {},
            xAxis: {
                data: xAxisData
            },
            series: series_list
        };
        initLineChart.setOption( option );
    }
    var initLineChartApiUrl = $("#initLine").attr("data-api-url");
    var initLineChartStatus = false;
    $("#initLine .card-close .refresh").click( function () {
        var alert_title = "<b>-启动数据-</b>";
        if( !initLineChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( initLineChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        initLineChartStatus = true;

        var reqUrl = initLineChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                initLineChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                initLineChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                initLineChartRefresh( resData );
            }
        });
    } );

    //激活数据折线图
    var activationLineChartDom = $("#activationLine .card-body").get(0);
    var activationLineChart = echarts.init( activationLineChartDom, "light", { height: parseInt( (activationLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function activationLineChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }

        var legendData = [];
        var xAxisData = [];
        var xAxisS = true;
        var series_list = [];

        for (var x in resData) {
            var series_li_data = [];
            for ( var y in resData[x] ) {
                if( xAxisS ) xAxisData.push( resData[x][y].date );
                series_li_data.push( resData[x][y].num );
            }
            var name = x + "( "+ arrayNumberSum( series_li_data ) +" )";
            legendData.push( name );
            if( xAxisS ) xAxisS = false;
            var series_li = {type: "line"};
            series_li.name = name;
            series_li.data = [].concat( series_li_data ); //拷贝
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: legendData
            },
            yAxis: {},
            xAxis: {
                data: xAxisData
            },
            series: series_list
        };
        activationLineChart.setOption( option );
    }
    var activationLineChartApiUrl = $("#activationLine").attr("data-api-url");
    var activationLineChartStatus = false;
    $("#activationLine .card-close .refresh").click( function () {
        var alert_title = "<b>-激活数据-</b>";
        if( !activationLineChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( activationLineChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        activationLineChartStatus = true;

        var reqUrl = activationLineChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                activationLineChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                activationLineChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                activationLineChartRefresh( resData );
            }
        });
    } );

    //活跃数据折线图
    var activeLineChartDom = $("#activeLine .card-body").get(0);
    var activeLineChart = echarts.init( activeLineChartDom, "light", { height: parseInt( (activeLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function activeLineChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }

        var legendData = [];
        var xAxisData = [];
        var xAxisS = true;
        var series_list = [];

        for (var x in resData) {
            var series_li_data = [];
            for ( var y in resData[x] ) {
                if( xAxisS ) xAxisData.push( resData[x][y].date );
                series_li_data.push( resData[x][y].num );
            }
            var name = x + "( "+ arrayNumberSum( series_li_data ) +" )";
            legendData.push( name );
            if( xAxisS ) xAxisS = false;
            var series_li = {type: "line"};
            series_li.name = name;
            series_li.data = [].concat( series_li_data ); //拷贝
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: legendData
            },
            yAxis: {},
            xAxis: {
                data: xAxisData
            },
            series: series_list
        };
        activeLineChart.setOption( option );
    }
    var activeLineChartApiUrl = $("#activeLine").attr("data-api-url");
    var activeLineChartStatus = false;
    $("#activeLine .card-close .refresh").click( function () {
        var alert_title = "<b>-活跃数据-</b>";
        if( !activeLineChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( activeLineChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        activeLineChartStatus = true;

        var reqUrl = activeLineChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                activeLineChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                activeLineChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                activeLineChartRefresh( resData );
            }
        });
    } );

    //次留数据折线图
    var oneRetainedLineChartDom = $("#oneRetainedLine .card-body").get(0);
    var oneRetainedLineChart = echarts.init( oneRetainedLineChartDom, "light", { height: parseInt( (oneRetainedLineChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function oneRetainedLineChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }

        var legendData = [];
        var xAxisData = [];
        var xAxisS = true;
        var series_list = [];
        //
        var channelSeriesData = [];

        for (var x in resData) {
            var series_li_data = [];
            var numSum = 0;
            for ( var y in resData[x] ) {
                if( xAxisS ) xAxisData.push( resData[x][y].date );
                series_li_data.push( resData[x][y].num );
                //
                numSum += parseInt( resData[x][y].num );
            }
            // var name = x + "( "+ arrayNumberSum( series_li_data ) +" )";
            var name = x + "( "+ numSum +" )";
            legendData.push( name );
            if( xAxisS ) xAxisS = false;
            var series_li = {type: "bar"};
            series_li.name = name;
            series_li.data = [].concat( series_li_data ); //拷贝
            series_list.push( series_li );

            var channelSeriesDataLi = {};
            channelSeriesDataLi.name = name;
            channelSeriesDataLi.value = numSum;
            channelSeriesData.push( channelSeriesDataLi );
        }

        var option = {
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: legendData
            },
            yAxis: {},
            xAxis: {
                data: xAxisData
            },
            series: series_list
        };
        oneRetainedLineChart.setOption( option );
        /**
         * 次留渠道数据(可根据次留数据分析)
         */
        var channelOption = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: legendData
            },
            series: [{
                name: "渠道",
                type: "pie",
                data: channelSeriesData
            }]
        };

        oneRetainedChannelBarChart.setOption( channelOption );
    }
    var oneRetainedLineChartApiUrl = $("#oneRetainedLine").attr("data-api-url");
    var oneRetainedLineChartStatus = false;
    $("#oneRetainedLine .card-close .refresh").click( function () {
        var alert_title = "<b>-次留数据-</b>";
        if( !oneRetainedLineChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( oneRetainedLineChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        oneRetainedLineChartStatus = true;

        var reqUrl = oneRetainedLineChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                oneRetainedLineChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                oneRetainedLineChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                oneRetainedLineChartRefresh( resData );
            }
        });
    } );
    
    //次留渠道数据饼图
    var oneRetainedChannelBarChartDom = $("#oneRetainedChannelBar .card-body").get(0);
    var oneRetainedChannelBarChart = echarts.init( oneRetainedChannelBarChartDom, "light", { height: parseInt( (oneRetainedChannelBarChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function oneRetainedChannelBarChartRefresh( ) {
    }
    $("#oneRetainedChannelBar .card-close .refresh").click( function () {
        // oneRetainedChannelBarChartRefresh();
    } );

    //渠道数据饼图
    var channelPieChartDom = $("#channelPie .card-body").get(0);
    var channelPieChart = echarts.init( channelPieChartDom, "light", { height: parseInt( (channelPieChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function channelPieChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }
        
        var legendData = [];
        var series_list = [];

        for( var x in resData ) {
            var series_li = { type: "pie" };

            for( var y in resData[x]) {
                resData[x][y].name += "( " + resData[x][y].value + " )";
                legendData.push( resData[x][y].name );
            }

            series_li.name = x;
            series_li.data = resData[x];
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: legendData
            },
            series: series_list
        };
        channelPieChart.setOption( option );
    }
    var channelPieChartApiUrl = $("#channelPie").attr("data-api-url");
    var channelPieChartStatus = false;
    $("#channelPie .card-close .refresh").click( function () {
        var alert_title = "<b>-渠道数据-</b>";
        if( !channelPieChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( channelPieChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        channelPieChartStatus = true;

        var reqUrl = channelPieChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                channelPieChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                channelPieChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                channelPieChartRefresh( resData );
            }
        });
    } );
/*
    //点击样式数据饼图
    var clickTypePieChartDom = $("#clickTypePie .card-body").get(0);
    var clickTypePieChart = echarts.init( clickTypePieChartDom, "light", { height: parseInt( (clickTypePieChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function clickTypePieChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }
        
        var legendData = [];
        var series_list = [];

        for( var x in resData ) {
            var series_li = { type: "pie" };

            for( var y in resData[x]) {
                resData[x][y].name += "( " + resData[x][y].value + " )";
                legendData.push( resData[x][y].name );
            }

            series_li.name = x;
            series_li.data = resData[x];
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: legendData
            },
            series: series_list
        };
        clickTypePieChart.setOption( option );
    }
    var clickTypePieChartApiUrl = $("#clickTypePie").attr("data-api-url");
    var clickTypePieChartStatus = false;
    $("#clickTypePie .card-close .refresh").click( function () {
        var alert_title = "<b>-点击样式数据-</b>";
        if( !clickTypePieChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( clickTypePieChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        clickTypePieChartStatus = true;

        var reqUrl = clickTypePieChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                clickTypePieChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                clickTypePieChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                clickTypePieChartRefresh( resData );
            }
        });
    } );

    //点击投放数据饼图
    var clickSitePieChartDom = $("#clickSitePie .card-body").get(0);
    var clickSitePieChart = echarts.init( clickSitePieChartDom, "light", { height: parseInt( (clickSitePieChartDom.getBoundingClientRect().width - 40) / 2 ) } );
    function clickSitePieChartRefresh( resData ) {
        if( typeof resData != "object" ) {
            console.log( resData );
            return;
        }
        
        var legendData = [];
        var series_list = [];

        for( var x in resData ) {
            var series_li = { type: "pie" };

            for( var y in resData[x]) {
                resData[x][y].name += "( " + resData[x][y].value + " )";
                legendData.push( resData[x][y].name );
            }

            series_li.name = x;
            series_li.data = resData[x];
            series_list.push( series_li );
        }

        var option = {
            tooltip: {
                trigger: "item"
            },
            legend: {
                orient: 'vertical',
                left: "1px",
                data: legendData
            },
            series: series_list
        };
        clickSitePieChart.setOption( option );
    }
    var clickSitePieChartApiUrl = $("#clickSitePie").attr("data-api-url");
    var clickSitePieChartStatus = false;
    $("#clickSitePie .card-close .refresh").click( function () {
        var alert_title = "<b>-点击投放数据-</b>";
        if( !clickSitePieChartApiUrl ) {
            content_alert( "error", alert_title + "api异常" );
            return;
        }

        if( clickSitePieChartStatus ) {
            content_alert( "warn", alert_title + "刷新频繁" );
            return;
        }
        clickSitePieChartStatus = true;

        var reqUrl = clickSitePieChartApiUrl;
        var reqData = getHomeDateFormData();
        $.ajax({
            url: reqUrl,
            type: "POST",
            data: reqData,
            dataType: "JSON",
            timeout: 10000, //超时时间
            processData: false, // jQuery不要去处理发送的数据
            contentType: false, // jQuery不要去设置Content-Type请求头
            error: function(xhr, status) {
                clickSitePieChartStatus = false;
                content_alert( "error", alert_title + "获取失败,请重试" );
            },
            success: function (result, status) {
                clickSitePieChartStatus = false;
                if( result.code != 0 ) {
                    content_alert( "error", alert_title + result.message );
                    return ;
                }

                var resData = result.data;
                clickSitePieChartRefresh( resData );
            }
        });
    } );
*/
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
        // clickTypePieChart.resize({ height: parseInt( (clickTypePieChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
        //点击样式数据饼图
        // clickSitePieChart.resize({ height: parseInt( (clickSitePieChart.getDom().getBoundingClientRect().width - 40) / 2 ) });
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