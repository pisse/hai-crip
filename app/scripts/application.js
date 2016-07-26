/* global define */
define([
	'application/scope',
	//'zepto',
	'application/views',
	'swipe'
], function (scope, Views, swipe) {
	'use strict';

	//var swipe = require(swpie);

	//console.log($.fn.Swipe);

	console.log('\'Allo \'Allo!', scope.id);
	//console.log($)

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

	//$.init();

	return scope;
});
