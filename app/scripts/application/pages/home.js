/* global define */
define([
	'../scope',
	//'zepto',
	'../views',
	'swipe'
], function (scope, Views, swipe) {
	'use strict';

	var slider = Swipe(document.getElementById("slider"), {
		auto: 3000,
		continuous: true,
		callback: function(pos) {
			var i = bullets.length;
			while (i--) {
				bullets[i].className = " "
			}
			bullets[pos].className = "hover"
		}
	});
	var bullets = document.getElementById("position").getElementsByTagName("li")

	$(document).on('infinite', '.infinite-scroll-bottom',function() {
		console.log(1)

		// 如果正在加载，则退出
		if (loading) return;

		// 设置flag
		loading = true;

		// 模拟1s的加载过程
		setTimeout(function() {
			// 重置加载flag
			loading = false;

			if (lastIndex >= maxItems) {
				// 加载完毕，则注销无限加载事件，以防不必要的加载
				$.detachInfiniteScroll($('.infinite-scroll'));
				// 删除加载提示符
				$('.infinite-scroll-preloader').remove();
				return;
			}

			// 添加新条目
			//addItems(itemsPerLoad, lastIndex);
			// 更新最后加载的序号
			lastIndex = $('.list-container li').length;
			//容器发生改变,如果是js滚动，需要刷新滚动
			$.refreshScroller();
		}, 1000);
	});

	/*$(".content").scroller({
		type: 'js'
	});*/

	return scope;
});
