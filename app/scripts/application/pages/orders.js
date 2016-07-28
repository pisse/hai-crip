/* global define */
define([

], function () {
	'use strict';

	/*$(".content").scroller({
		type: 'js'
	});
*/

	$("#disp_nickname").click(function(){
		$.router.load("#editnickname");
	});

});
