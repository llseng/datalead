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
        console.log( "数据刷新点击事件" );
    });
    //刷新
    $("#home-date-btn .btn").eq(0).trigger('click');
    //刷新
    $("#home-date-submit .btn-success").trigger('click');

    var clickLineChartDom = document.getElementById("clickLineChart");
    var clickLineChart = new Chart( clickLineChartDom, {
        type: "line",
        data: {
            labels: ["1","2","3","4","5","6"],
            datasets: [
                {
                    label: "字节跳动",
                    data: [16,54,84,56,543,5]
                },
                {
                    label: "自然",
                    data: [99,49,84,85,65,498]
                }
            ]
        }
    } );
} );