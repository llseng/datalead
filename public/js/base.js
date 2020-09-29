Date.prototype.format = function(fmt){
    var o = {
        "M+" : this.getMonth()+1,                 //月份
        "d+" : this.getDate(),                    //日
        "h+" : this.getHours(),                   //小时
        "m+" : this.getMinutes(),                 //分
        "s+" : this.getSeconds(),                 //秒
        "q+" : Math.floor((this.getMonth()+3)/3), //季度
        "S"  : this.getMilliseconds()             //毫秒
    };

    if(/(y+)/.test(fmt)){
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    }
            
    for(var k in o){
        if(new RegExp("("+ k +")").test(fmt)){
        fmt = fmt.replace(
            RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));  
        }       
    }

    return fmt;
}

function arrayNumberSum ( Arr ) {
    if( typeof Arr != "object" ) return 0;
    var sum = 0;
    for( var x in Arr ) {
        if( typeof Arr[x] == "number" ) {
            sum += Arr[x];
        }
    }

    return sum;
}

function delete_confirm_url( url ) {
    if( confirm( "删除后不可恢复,确认删除?" ) ) {
        window.location.href = url;
    }
}

function copy( text ) {
    let transfer = document.createElement('input');
    document.body.appendChild(transfer);
    transfer.value = text;  // 这里表示想要复制的内容
    transfer.focus();
    transfer.select();
    if (document.execCommand('copy')) {
        document.execCommand('copy');
    }
    transfer.blur();
    console.log('复制成功');
    document.body.removeChild(transfer);

}