$(document).ready( function() {

    "use strict";

    //生成回调按钮
    var $create_callback_btn_doms = $(".update-btns>.btn[data-btn='create_callback']");

    $create_callback_btn_doms.on( 'click', function () {
        var trDom = this.parentNode.parentNode;
        var pval = trDom.getAttribute( 'data-pval' );

        //内容
        var content = $(trDom).children("td[data-key='content']").html();
        try {
            var content_res = JSON.parse( content );
            var callback_url = content_res.callback_url;
            var other_str = "event_type=0";
            if( !callback_url ) {
                content_alert( "error", "空回调地址, 操作失败" );
            }

            var match = callback_url.match(/^http[s]?:\/\/\w+(\.\w+)+.+/);
            if( !match ) {
                content_alert( "error", "回调地址不是正常的API接口, 操作失败" );
            }

            if( callback_url.indexOf('?') < 0 ) {
                callback_url += "?"
            }else{
                callback_url += "&"
            }

            callback_url += other_str;

            console.log( "回调地址: "+ callback_url );

            copy( callback_url );

            alert( "回调地址已复制, 直接粘贴即可. PS: 可在控 制后台(F12) 获取" );

        } catch (error) {
            console.log( error );
            content_alert( "error", "数据异常, 操作失败" );
        }
    } );

});