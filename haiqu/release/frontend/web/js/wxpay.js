//调用微信JS api 支付
var wxpayJsApiParameters = '';
var wxpayCallBack = function(){};
function jsApiCall()
{
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        wxpayJsApiParameters,
        function(res){
            wxpayCallBack(res);
            //alert(res.err_code+res.err_desc+res.err_msg);
        }
    );
}
function callpay()
{
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    }else{
        jsApiCall();
    }
}