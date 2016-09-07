<?php

use yii\helpers\Url;

function showheader($key, $menuname, $url) {
	echo '<li><em><a href="'.$url.'" id="header_'.$key.'" hidefocus="true" onmouseover="previewheader(\''.$key.'\')" onmouseout="previewheader()" onclick="toggleMenu(\''.$key.'\', \''.$url.'\');doane(event);">'.$menuname.'</a></em></li>';
}

function showmenu($key, $menus) {
	$body = '';
	if(is_array($menus)) {
		foreach($menus as $menu) {
			if ($menu[0] && $menu[1] == 'groupbegin') {
				$id = 'M'.substr(md5($menu[0]), 0, 8);
				$hide = false;
				$body .= '<li class="s"><div class="lsub'.($hide ? '' : ' desc').'" subid="'.$id.'"><div onclick="lsub(\''.$id.'\', this.parentNode)">'.$menu[0].'</div><ol style="display:'.($hide ? 'none' : '').'" id="'.$id.'">';
			} elseif ($menu[0] && $menu[1] == 'groupend') {
				$body .= '<li class="sp"></li></ol></div></li>';
			} elseif ($menu[0] && !empty($menu[1])) {
				$body .= '<li><a href="'.$menu[1].'" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="新窗口打开"></em>'.$menu[0].'</a></li>';
			}
		}
	}
	
	echo '<ul id="menu_'.$key.'" style="display: none">'.$body.'</ul>';
}

$basescript = 'index.php';
$extra = isset($_GET['action']) ? ('r=' . urlencode($_GET['action'])) : ('r=' . urlencode('main/home'));
$BASEURL = Yii::$app->getRequest()->getBaseUrl();
$username = Yii::$app->user->identity->username;
$logoutUrl = Url::toRoute('main/logout');

echo <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>后台管理系统</title>
<meta content="Comsenz Inc." name="Copyright" />
<link rel="stylesheet" href="{$BASEURL}/image/admincp.css?v=2015072101" type="text/css" media="all" />
<link rel="stylesheet" href="{$BASEURL}/css/site.css" type="text/css" media="all" />
<script src="{$BASEURL}/js/dcz_common.js" type="text/javascript"></script>
</head>
<body style="margin: 0px" scroll="no">
<div id="append_parent"></div>
<table id="frametable" cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
<td colspan="2" height="90">
<div class="mainhd">
<a href="#" class="logo">嗨去</a>
<div class="uinfo" id="frameuinfo">
<p>您好，<em>{$username}</em> [<a href="{$logoutUrl}" target="_top">退出</a>]</p>
<p class="btnlink"><a href="#">站点首页</a></p>
</div>
<div class="navbg"></div>
<div class="nav">
<ul id="topmenu">

EOT;

foreach($topmenu as $k => $v) {
	showheader($k, $v[0], $v[1]);
}

$headers = "'".implode("','", array_keys($topmenu))."'";

echo <<<EOT

</ul>
<div class="currentloca">
<p id="admincpnav"></p>
</div>
<div class="navbd"></div>
</div>
</div>
</td>
</tr>
<tr>
<td valign="top" width="160" class="menutd">
<div id="leftmenu" class="menu">

EOT;

foreach ($menu as $k => $v) {
	showmenu($k, $v);
}

$plugindefaultkey = 0;

echo <<<EOT

</div>
</td>
<td valign="top" width="100%" class="mask">
	<iframe src="$basescript?$extra" id="main" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;display:"></iframe>
</td>
</tr>
</table>
<div id="scrolllink" style="display: none">
	<span onclick="menuScroll(1)"><img src="{$BASEURL}/image/scrollu.gif" /></span><span onclick="menuScroll(2)"><img src="{$BASEURL}/image/scrolld.gif" /></span>
</div>

<div id="cpmap_menu" class="custom" style="display: none">
	<div class="cmain" id="cmain"></div>
	<div class="cfixbd"></div>
</div>

<script type="text/JavaScript">
	var cookiepre = '', cookiedomain = '', cookiepath = '';
	var headers = new Array($headers), admincpfilename = '$basescript', menukey = '';
	function switchheader(key) {
		if(!key || !$('header_' + key)) {
			return;
		}
		for(var k in top.headers) {
			if($('menu_' + headers[k])) {
				$('menu_' + headers[k]).style.display = headers[k] == key ? '' : 'none';
			}
		}
		var lis = $('topmenu').getElementsByTagName('li');
		for(var i = 0; i < lis.length; i++) {
			if(lis[i].className == 'navon') lis[i].className = '';
		}
		$('header_' + key).parentNode.parentNode.className = 'navon';
	}
	var headerST = null;
	function previewheader(key) {
		if(key) {
			headerST = setTimeout(function() {
				for(var k in top.headers) {
					if($('menu_' + headers[k])) {
						$('menu_' + headers[k]).style.display = headers[k] == key ? '' : 'none';
					}
				}
				var hrefs = $('menu_' + key).getElementsByTagName('a');
				for(var j = 0; j < hrefs.length; j++) {
					hrefs[j].className = '';
				}
			}, 1000);
		} else {
			clearTimeout(headerST);
		}
	}
	function toggleMenu(key, url) {
		menukey = key;
		switchheader(key);
		if(url) {
			parent.main.location = url;
			var hrefs = $('menu_' + key).getElementsByTagName('a');
			for(var j = 0; j < hrefs.length; j++) {
				hrefs[j].className = j == (key == 'plugin' ? $plugindefaultkey : 0) ? 'tabon' : '';
			}
		}
		if(key == 'uc') {
			parent.main.location = $('header_uc').href + '&a=main&iframe=1';
		}
		setMenuScroll();
	}
	function setMenuScroll() {
		$('frametable').style.width = document.body.offsetWidth < 1000 ? '1000px' : '100%';
		var obj = $('menu_' + menukey);
		if(!obj) {
			return;
		}
		var scrollh = document.body.offsetHeight - 130;
		obj.style.overflow = 'visible';
		obj.style.height = '';
		$('scrolllink').style.display = 'none';
		if(obj.offsetHeight + 150 > document.body.offsetHeight && scrollh > 0) {
			obj.style.overflow = 'hidden';
			obj.style.height = scrollh + 'px';
			$('scrolllink').style.display = '';
		}
	}
	function resizeHeadermenu() {
		var lis = $('topmenu').getElementsByTagName('li');
		var maxsize = $('frameuinfo').offsetLeft - 160, widths = 0, moi = -1, mof = '';
		if($('menu_mof')) {
			$('topmenu').removeChild($('menu_mof'));
		}
		if($('menu_mof_menu')) {
			$('append_parent').removeChild($('menu_mof_menu'));
		}
		for(var i = 0; i < lis.length; i++) {
			widths += lis[i].offsetWidth;
			if(widths > maxsize) {
				lis[i].style.visibility = 'hidden';
				var sobj = lis[i].childNodes[0].childNodes[0];
				if(sobj) {
					mof += '<a href="'+ sobj.getAttribute('href') + '" onclick="$(\'' + sobj.id + '\').onclick()">&rsaquo; ' + sobj.innerHTML + '</a><br style="clear:both" />';
				}
			} else {
				lis[i].style.visibility = 'visible';
			}
		}
		if(mof) {
			for(var i = 0; i < lis.length; i++) {
				if(lis[i].style.visibility == 'hidden') {
					moi = i;
					break;
				}
			}
			mofli = document.createElement('li');
			mofli.innerHTML = '<em><a href="javascript:;">&raquo;</a></em>';
			mofli.onmouseover = function () { ({'ctrlid':'menu_mof','pos':'43'});mofmli.style.display = 'block'; }
			mofli.id = 'menu_mof';
			$('topmenu').insertBefore(mofli, lis[moi]);
			mofmli = document.createElement('li');
			mofmli.className = 'popupmenu_popup';
			mofmli.onmouseover = function () { mofmli.style.display = 'block'; }
			mofmli.onmouseout = function () { mofmli.style.display = 'none'; }
			var mofmli_width = 150;
			mofmli.style.width = mofmli_width + 'px';
			mofmli.innerHTML = mof;
			mofmli.id = 'menu_mof_menu';
			mofmli.style.display = 'none';
			mofmli.style.position="absolute";
			mofmli.style.top = "85px";
			mofmli.style.marginLeft = (maxsize+ mofmli_width)+"px";
			$('append_parent').appendChild(mofmli);
		}
	}
	function menuScroll(op, e) {
		var obj = $('menu_' + menukey);
		var scrollh = document.body.offsetHeight - 160;
		if(op == 1) {
			obj.scrollTop = obj.scrollTop - scrollh;
		} else if(op == 2) {
			obj.scrollTop = obj.scrollTop + scrollh;
		} else if(op == 3) {
			if(!e) e = window.event;
			if(e.wheelDelta <= 0 || e.detail > 0) {
				obj.scrollTop = obj.scrollTop + 20;
			} else {
				obj.scrollTop = obj.scrollTop - 20;
			}
		}
	}
	function menuNewwin(obj) {
		var href = obj.parentNode.href;
		if(obj.parentNode.href.indexOf(admincpfilename + '?') != -1) {
			href += '&frames=yes';
		}
		window.open(href);
		doane();
	}
	function initCpMenus(menuContainerid) {
		var key = '', lasttabon1 = null, lasttabon2 = null, hrefs = $(menuContainerid).getElementsByTagName('a');
		for(var i = 0; i < hrefs.length; i++) {
			if(menuContainerid == 'leftmenu' && '$extra'.indexOf(hrefs[i].href.substr(hrefs[i].href.indexOf(admincpfilename + '?') + admincpfilename.length + 1)) != -1) {
				if(lasttabon1) {
					lasttabon1.className = '';
				}
				if(hrefs[i].parentNode.parentNode.tagName == 'OL') {
					hrefs[i].parentNode.parentNode.style.display = '';
					hrefs[i].parentNode.parentNode.parentNode.className = 'lsub desc';
					key = hrefs[i].parentNode.parentNode.parentNode.parentNode.parentNode.id.substr(5);
				} else {
					key = hrefs[i].parentNode.parentNode.id.substr(5);
				}
				hrefs[i].className = 'tabon';
				lasttabon1 = hrefs[i];
			}
			if(!hrefs[i].getAttribute('ajaxtarget')) hrefs[i].onclick = function() {
				if(menuContainerid != 'custommenu') {
					var lis = $(menuContainerid).getElementsByTagName('li');
					for(var k = 0; k < lis.length; k++) {
						if(lis[k].firstChild && lis[k].firstChild.className != 'menulink') {
							if(lis[k].firstChild.tagName != 'DIV') {
								lis[k].firstChild.className = '';
							} else {
								var subid = lis[k].firstChild.getAttribute('sid');
								if(subid) {
									var sublis = $(subid).getElementsByTagName('li');
									for(var ki = 0; ki < sublis.length; ki++) {
										if(sublis[ki].firstChild && sublis[ki].firstChild.className != 'menulink') {
											sublis[ki].firstChild.className = '';
										}
									}
								}
							}
						}
					}
					if(this.className == '') this.className = menuContainerid == 'leftmenu' ? 'tabon' : '';
				}
				if(menuContainerid != 'leftmenu') {
					var hk, currentkey;
					var leftmenus = $('leftmenu').getElementsByTagName('a');
					for(var j = 0; j < leftmenus.length; j++) {
						if(leftmenus[j].parentNode.parentNode.tagName == 'OL') {
							hk = leftmenus[j].parentNode.parentNode.parentNode.parentNode.parentNode.id.substr(5);
						} else {
							hk = leftmenus[j].parentNode.parentNode.id.substr(5);
						}
						if(this.href.indexOf(leftmenus[j].href) != -1) {
							if(lasttabon2) {
								lasttabon2.className = '';
							}
							leftmenus[j].className = 'tabon';
							if(leftmenus[j].parentNode.parentNode.tagName == 'OL') {
								leftmenus[j].parentNode.parentNode.style.display = '';
								leftmenus[j].parentNode.parentNode.parentNode.className = 'lsub desc';
							}
							lasttabon2 = leftmenus[j];
							if(hk != 'index') currentkey = hk;
						} else {
							leftmenus[j].className = '';
						}
					}
					if(currentkey) toggleMenu(currentkey);
					hideMenu();
				}
			}
		}
		return key;
	}
	function lsub(id, obj) {
		display(id);
		obj.className = obj.className != 'lsub' ? 'lsub' : 'lsub desc';
		if(obj.className != 'lsub') {
			setcookie('cpmenu_' + id, '');
		} else {
			setcookie('cpmenu_' + id, 1, 31536000);
		}
		setMenuScroll();
	}
	var header_key = initCpMenus('leftmenu');
	toggleMenu(header_key ? header_key : 'index');
	function initCpMap() {
		var ul, hrefs, s = '', count = 0;
		for(var k in headers) {
			if(headers[k] != 'index' && headers[k] != 'uc' && $('header_' + headers[k])) {
				s += '<tr><td valign="top"><h4>' + $('header_' + headers[k]).innerHTML + '</h4></td><td valign="top">';
				ul = $('menu_' + headers[k]);
				if(!ul) {
					continue;
				}
				hrefs = ul.getElementsByTagName('a');
				for(var i = 0; i < hrefs.length; i++) {
					s += '<a href="' + hrefs[i].href + '" target="' + hrefs[i].target + '" k="' + headers[k] + '">' + hrefs[i].innerHTML + '</a>';
				}
				s += '</td></tr>';
				count++;
			}
		}
		var width = 720;
		s = '<div class="cnote" style="width:' + width + 'px"><span class="right"><a href="###" class="flbc" onclick="hideMenu();return false;"></a></span><h3></h3></div>' +
			'<div class="cmlist" style="width:' + width + 'px;height: 410px"><table id="mapmenu" cellspacing="0" cellpadding="0">' + s +
			'</table></div>';
		$('cmain').innerHTML = s;
		$('cmain').style.width = (width > 1000 ? 1000 : width) + 'px';
	}
	initCpMap();
	initCpMenus('mapmenu');
	var cmcache = false;
	function showMap() {
		({'ctrlid':'cpmap','evt':'click', 'duration':3, 'pos':'00'});
	}
	function resetEscAndF5(e) {
		e = e ? e : window.event;
		actualCode = e.keyCode ? e.keyCode : e.charCode;
		if(actualCode == 27) {
			if($('cpmap_menu').style.display == 'none') {
				showMap();
			} else {
				hideMenu();
			}
		}
		if(actualCode == 116 && parent.main) {
			parent.main.location.reload();
			if(document.all) {
				e.keyCode = 0;
				e.returnValue = false;
			} else {
				e.cancelBubble = true;
				e.preventDefault();
			}
		}
	}
	function uc_left_menu(uc_menu_data) {
		var leftmenu = $('menu_uc');
		leftmenu.innerHTML = '';
		var html_str = '';
		for(var i=0;i<uc_menu_data.length;i+=2) {
			html_str += '<li><a href="'+uc_menu_data[(i+1)]+'" hidefocus="true" onclick="uc_left_switch(this)" target="main"><em onclick="menuNewwin(this)" title="新窗口打开"></em>'+uc_menu_data[i]+'</a></li>';
		}
		leftmenu.innerHTML = html_str;
	}
	var uc_left_last = null;
	function uc_left_switch(obj) {
		if(uc_left_last) {
			uc_left_last.className = '';
		}
		obj.className = 'tabon';
		uc_left_last = obj;
	}
	function uc_modify_sid(sid) {
		$('header_uc').href = '#';
	}

	_attachEvent(document.documentElement, 'keydown', resetEscAndF5);
	_attachEvent(window, 'resize', setMenuScroll, document);
	_attachEvent(window, 'resize', resizeHeadermenu, document);
	if(BROWSER.ie){
		$('leftmenu').onmousewheel = function(e) { menuScroll(3, e) };
	} else {
		$('leftmenu').addEventListener("DOMMouseScroll", function(e) { menuScroll(3, e) }, false);
	}
	resizeHeadermenu();
</script>
</body>
</html>

EOT;
?>