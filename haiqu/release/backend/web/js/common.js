/**
 *
 *  使用前先引用jquery文件
 *
 */
var u = navigator.userAgent;
window.browser = {};
window.browser.iPhone = u.indexOf('iPhone') > -1;
window.browser.android = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1;//android or uc
window.browser.ipad = u.indexOf('iPad') > -1;
window.browser.isclient = u.indexOf('lyWb') > -1;
window.browser.ios = u.match(/Mac OS/); //ios
window.browser.width = window.innerWidth;
window.browser.height = window.innerHeight;
window.browser.wx = u.match(/MicroMessenger/);
getQueryString('source_tag') && window.localStorage.setItem("source_tag",getQueryString('source_tag'));
window.source_tag = localStorage.source_tag ? localStorage.source_tag : 'wap';

//获取url参数的值
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}

/**
 *===================遮罩层begin=============
*/
function showExDialog(tips,btn1,func1,btn2,func2){
    hideExDialog();
    func1 = arguments[2] ? arguments[2] : 'hideExDialog';
    func2 = arguments[4] ? arguments[4] : 'hideExDialog';
    func1 = func1.indexOf('(') > 0 ? func1+';' : func1+'();';
    func2 = func2.indexOf('(') > 0 ? func2+';' : func2+'();';
    var str = '';
    str += '<div id="mask"></div>';
    str += '<div id="exception_dialog_wraper"><div id="exception_dialog">';
    str += '<div class="a_center" id="exception_dialog_tips">'+tips+'</div>';
    if(arguments[1]){
        str += '<div class="_inline_block exception_dialog_btn" onclick="'+func1+'">'+btn1+'</div>';
    }
    if(arguments[3]){
        str += '<div class="_inline_block exception_dialog_btn" onclick="'+func2+'">'+btn2+'</div>';
    }
    str += '</div></div>';
    $(".kdlc_mobile_wraper > div").append(str);
    if( !arguments[3] && !arguments[4] ){
        $(".exception_dialog_btn").width("80%");
    }
    $(document.body).css({"overflow-x":"hidden","overflow-y":"hidden"});
}
function hideExDialog(){
    $("#mask,#exception_dialog_wraper").remove();
    $(document.body).css({"overflow-x":"auto","overflow-y":"auto"});
}
/**
*===================遮罩层end=============
*/



/*
 *限制只能输入数字
 * 含value属性的标签
 * eg: onkeyup事件
*/
function justInt(e){
    e.value = e.value.replace(/[^\d]/g,'');
}

/*
 *限制只能输入浮点数
 * 含value属性的标签
 * eg: onkeyup事件
*/
function justFloat(e){
    e.value=e.value.replace(/[^\d+(\.\d+)?$]/g,'');
}

var KD = {};
KD.util = {};
KD.util.post = function(url, data, okfn) {
    KD.util.post.pIndex = (KD.util.post.pIndex || 0) + 1;
    var iframe = $('<iframe name="pIframe_'+KD.util.post.pIndex+'" src="about:blank" style="display:none" width="0" height="0" scrolling="no" allowtransparency="true" frameborder="0"></iframe>').appendTo($(document.body));

    var ipts = [];
    $.each(data, function(k, v){
        ipts.push('<input type="hidden" name="'+k+'" value="" />');
    });
    
    if(!/(\?|&(amp;)?)fmt=[^0 &]+/.test(url)) url += (url.indexOf('?') > 0 ? '&' : '?') + 'fmt=1';

    var form = $('<form action="'+url+'" method="post" target="pIframe_'+KD.util.post.pIndex+'">'+ipts.join('')+'</form>').appendTo($(document.body));

    $.each(data, function(k, v){
        form.children('[name='+k+']').val(v);
    });

    iframe[0].callback = function(o){
        if(typeof okfn == 'function') okfn(o);
        $(this).src = 'about:blank';
        $(this).remove();
        form.remove();
        iframe = form = null;
    };
    if(false && $.browser.msie && $.browser.version == 6.0){ // 暂不考虑ie6，且$.browser还不行
        iframe[0].pIndex = KD.util.post.pIndex;
        iframe[0].ie6callback = function(){
            form.target = 'pIframe_' + this.pIndex;
            form.submit();
        };
        iframe[0].src = location.protocol + '//m.668ox.com/html/ie6post.html';
    } else {
        form.submit();
    }
};

//获取ID
function ID(id) {
    return !id ? null : document.getElementById(id);
}

function jumpTo(url){
    window.location.href = url;
}


/**
 * 表单提交
 * @param URL
 * @param PARAMS 
 * @param METHOD
 */
function formPost(URL, PARAMS, METHOD){
    var temp = document.createElement("form");
    temp.action = URL;
    temp.method = METHOD || 'POST';
    temp.style.display = "none";
    for (var x in PARAMS){
        var opt = document.createElement("textarea");
        opt.name = x;
        opt.value = PARAMS[x];
        temp.appendChild(opt);
    }
    document.body.appendChild(temp);
    temp.submit();
    return temp;
}

/*
 *获取来源URL
*/
function getSourceUrl(){
    return document.referrer ? document.referrer : '/';
}

/*
 * 转换成整型
*/
function intval(num){
    var ret = parseInt(num);
    return isNaN(ret) ?  0 : ret;
}
