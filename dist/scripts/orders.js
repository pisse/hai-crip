/* global define */
require([

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

define("orders", function(){});

