/* global define */
define('profile',[

], function () {
	'use strict';

	/*$(".content").scroller({
		type: 'js'
	});
*/

	$("#disp_nickname").click(function(){
		$.router.load("#editnickname");
	});

	$("#disp_phone").click(function(){
		$.router.load("#editphone");
	});

});

