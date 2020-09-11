$(document).ready( function() {

    "use strict";

    var table_dom = document.getElementById( 'table' );
    var info_url = table_dom.getAttribute( "data-info-url" );
    var handle_url = table_dom.getAttribute( "data-handle-url" );
    var delete_url = table_dom.getAttribute( "data-delete-url" );

    //详情按钮
    var $info_btn_doms = $(".update-btns>.btn[data-btn='info']");
    //处理按钮
    var $handle_btn_doms = $(".update-btns>.btn[data-btn='handle']");
    //删除按钮
    var $delete_btn_doms = $(".update-btns>.btn[data-btn='delete']");
    
    if( info_url && $info_btn_doms.length ) {
        $info_btn_doms.on( 'click', function() {
            var trDom = this.parentNode.parentNode;
            var pval = trDom.getAttribute( 'data-pval' );
    
            var reqData = { id: pval };
            $.ajax({
                url: info_url,
                type: "GET",
                data: reqData,
                dataType: "JSON",
                timeout: 10000, //超时时间
                error: function(xhr, status) {
                    content_alert( "error", "获取失败,请重试" );
                },
                success: function (result, status) {
                    if( result.code != 0 ) {
                        content_alert( "error", result.message );
                        return ;
                    }
    
                    var resData = result.data;
                    console.log( resData.id );
                    $(trDom).children("td[data-key='url']").html( '<textarea>' + resData.url + '</textarea>' );
                    $(trDom).children("td[data-key='res']").html( '<textarea>' + resData.res + '</textarea>' );
                }
            });
            
        } );
    }else{
        content_alert( "error", "详情按钮异常" );
    }

    if( handle_url && $handle_btn_doms.length ) {
        $handle_btn_doms.on( 'click', function() {
            var trDom = this.parentNode.parentNode;
            var pval = trDom.getAttribute( 'data-pval' );
    
            var reqData = { id: pval };
            $.ajax({
                url: handle_url,
                type: "GET",
                data: reqData,
                dataType: "JSON",
                timeout: 10000, //超时时间
                error: function(xhr, status) {
                    content_alert( "error", "获取失败,请重试" );
                },
                success: function (result, status) {
                    if( result.code != 0 ) {
                        content_alert( "error", result.message );
                        return ;
                    }
    
                    var resData = result.data;
                    console.log( resData.id );
                    $(trDom).children("td[data-key='url']").html( '<textarea>' + resData.url + '</textarea>' );
                    $(trDom).children("td[data-key='res']").html( '<textarea>' + resData.res + '</textarea>' );
                    $(trDom).children("td[data-key='updated_at']").html( resData.datetime );
                    $(trDom).children("td[data-key='status']").html( "已处理" );
                }
            });
        } );
    }else{
        content_alert( "error", "处理按钮异常" );
    }
    

    if( delete_url && $delete_btn_doms.length ) {
        $delete_btn_doms.on( 'click', function() {
            if( !confirm( "删除后不可恢复,确认删除?") ) return;
            var trDom = this.parentNode.parentNode;
            var pval = trDom.getAttribute( 'data-pval' );
    
            var reqData = { id: pval };
            $.ajax({
                url: delete_url,
                type: "GET",
                data: reqData,
                dataType: "JSON",
                timeout: 10000, //超时时间
                error: function(xhr, status) {
                    content_alert( "error", "获取失败,请重试" );
                },
                success: function (result, status) {
                    if( result.code != 0 ) {
                        content_alert( "error", result.message );
                        return ;
                    }
    
                    var resData = result.data;
                    console.log( resData.id );
                    $(trDom).remove();
                }
            });

        } );
    }else{
        content_alert( "error", "删除按钮异常" );
    }

});