/* global define */
require([
	'../scope',
	//'zepto',
	'../views',
	'swipe',
	"../templates/templates","../templates/helper"
], function (scope, Views, swipe, Template) {
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
	var bullets = document.getElementById("position").getElementsByTagName("li");


	/*$(".content").scroller({
		type: 'js'
	});*/

	return scope;
});
