function skipApp(obj,refresh)
{
  var isiOS = navigator.userAgent.match('iPad') || navigator.userAgent.match('iPhone') || navigator.userAgent.match('iPod'),
    isAndroid = navigator.userAgent.match('Android');
  var url;
  if(isAndroid) {
  } else if(isiOS){
  }
  window.addEventListener('load',function(){
      var ios_versions_num = 0;
      if(isiOS){
          var reg = /(\d+_)+/ig;
          var ios_versions = navigator.userAgent.match(reg);
          reg = /\d+/i;
          var ios_versions_num = ios_versions.toString().match(reg);
      }
      if(parseInt(ios_versions_num)==9){
          var isrefresh = refresh; // 获得refresh参数  
           if(isrefresh == 1) {
               return ;
           }
          window.location.href=url;
          window.setTimeout(function () {  
              window.location.href += '&refresh=1' // 附加一个特殊参数，用来标识这次刷新不要再调用myapp:// 了  
           }, 5000);
      }else{
          var ifr = document.createElement('iframe');
          ifr.src = url;
          ifr.style.display = 'none';
          document.body.appendChild(ifr);
          window.setTimeout(function(){
              document.body.removeChild(ifr);
          },5000);
      }
  }, false);
}