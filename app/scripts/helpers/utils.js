/* global define */
define([
	'../application/scope',
	'../../mock/mockdata'
], function (scope, Data) {
	'use strict';

	var Config = {
		useMock: true
	};

	var utils = {
		request: function(opt){

            if( !(opt.mask === false) ){
                $.showIndicator();
            }

			if(Config.useMock){

				if ( opt.success ) {
					setTimeout(function(){
						opt.success(Data[opt.url]);

                        if( !(opt.mask === false) ){
                            $.hideIndicator();
                        }

					}, 1000);
				}

			} else {

				if( !opt.data ){
					opt.data = {};
				}

				var mobile =  localStorage.getItem("mobile");
				var skey =  localStorage.getItem("skey");

				if( mobile && !opt.data.mobile ){
					opt.data.mobile = mobile;
				}
				if( skey ){
					opt.data.skey = skey;
				}

				/* console.log(opt);
				 return;*/

				$.getJSON({
					type: opt.type ? opt.type : 'post',
					url: Config.devUrl + opt.url,
					data: opt.data,
					dataType: opt.dataType ? opt.dataType : 'json',
					success: function(rdata) {
						if ( rdata.ret_code == 0 || rdata.err_code == 0 ) {
							if ( opt.success ) {
								opt.success(rdata);
							}
						}
						else {
							if ( opt.error ) {
								opt.error(rdata);
							}
						}

                        if( !(opt.mask === false) ){
                            $.hideIndicator();
                        }
					},
					error: function(rdata) {
                        if( !(opt.mask === false) ){
                            $.hideIndicator();
                        }
					}
				});

			}
		},
	}

	scope.utils = utils;

	return scope;
});
