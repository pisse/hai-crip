//根据分辨率设置根元素html的font-size大小，方便使用rem进行自适应写法
//目前上线的新版注册页有一个引入的mediaquery版css，为防止冲突，就不加在common.js了
! function(x) {
	function w() {
		var v, u, t, tes,
			s = x.document,
			r = s.documentElement,
			a = r.getBoundingClientRect().width;

		if (!v && !u) {
			var n = !!x.navigator.appVersion.match(/AppleWebKit.*Mobile.*/);
			v = x.devicePixelRatio;
			tes = x.devicePixelRatio;
			v = n ? v : 1, u = 1 / v;
		}

		if (v <= 2 && a >= 960) {
			r.style.fontSize = "40px";
		} else {
			r.style.fontSize = a / 320 * 20 + "px";
		}
	}

	x.addEventListener("resize", function() {
		w();
	});
	w();
}(window);