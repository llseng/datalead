"use strict";

//提示框容器
var contentAlertDom = document.getElementById( "content_alert" );
if( !contentAlertDom ) contentAlertDom = document.getElementsByTagName( "body" );

function content_alert( type, message, close_btn ) {
    var type_list = ['light', 'dark', 'success', 'info', 'warning', 'danger', 'primary', 'secondary'];
    
    if( !message ) message = "Message";
    if( !close_btn ) close_btn = true;
    
    switch ( type ) {
        case "succ":
            type = "success";
            break;
        case "warn":
            type = "warning";
            break;
        case "error":
            type = "danger";
            break;
    }

    if( type_list.indexOf( type ) < 0 ) type = type_list[0];
    
    var html = '<div class="alert alert-' + type + ' '+ (close_btn? 'alert-dismissible': '') +'">';
    if( close_btn ) html += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    html += message;
    html += '</div>';

    contentAlertDom.innerHTML += html;
}