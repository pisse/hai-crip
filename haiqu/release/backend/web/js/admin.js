/**
 * 后台公用js
 */

// 原生方式通过id获取dom，代替discuz的$方法
function $id(id) {
	return !id ? null : document.getElementById(id);
}

// 弹出确认是否继续操作提示
function confirmMsg(msg) {
	if (confirm(msg)) {
		return true;
	} else {
		return false;
	}
}

// 跳转
function redirect(url) {
	window.location.replace(url);
}

// 切换导航锚点，控制选中显示，非选中隐藏
function showanchor(obj) {
	var navs = $id('submenu').getElementsByTagName('li');
	for(var i = 0; i < navs.length; i++) {
		if(navs[i].id.substr(0, 4) == 'nav_' && navs[i].id != obj.id) {
			if($id(navs[i].id.substr(4))) {
				navs[i].className = '';
				$id(navs[i].id.substr(4)).style.display = 'none';
				if($id(navs[i].id.substr(4) + '_tips')) $id(navs[i].id.substr(4) + '_tips').style.display = 'none';
			}
		}
	}
	obj.className = 'current';
	currentAnchor = obj.id.substr(4);
	$id(currentAnchor).style.display = '';
	if($id(currentAnchor + '_tips')) $id(currentAnchor + '_tips').style.display = '';
	if($id(currentAnchor + 'form')) {
		$id(currentAnchor + 'form').anchor.value = currentAnchor;
	} else if($id('cpform')) {
		$id('cpform').anchor.value = currentAnchor;
	}
}

function confirmRedirect(msg, url) {
	if(confirmMsg(msg)){
        window.location.href = url;
        return true;
    }else{
        return false;
    }
}