$(document).ready( function() {

    'use strict'; //开启严格模式

    $("#home-date-range").datepicker({
        format: "yyyy-mm-dd",
        language: "zh-CN",
        // todayBtn: true,
        todayHighlight: true
    }); //时间范围

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

        console.log(start_date.format("yyyy-MM-dd"), end_date.format("yyyy-MM-dd"));

        $this.addClass( "active" );
    });

    $("#home-date-submit .btn-success").click( function (){
        console.log( this );
    });
} );