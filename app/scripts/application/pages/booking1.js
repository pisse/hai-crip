/* global define */
define([
	"../templates/templates","../templates/helper"
], function (Template) {
	'use strict';
	var data = {
		"dates": {
			"2016-07-30": {
				"startPrice": 3439,
				"adultPrice": 4039,
				"excludeChildFlag": 0,
				"childPrice": 2049,
				"freeChildPrice": 699,
				"roomGrapFlag": 1,
				"flightTicketType": 1,
				"strategyType": 1,
				"bookCityCode": 2500,
				"departureCityCode": 2500,
				"discount": 600,
				"discountDesc": [{
					"discountName": "立减优惠",
					"discountPrice": 600,
					"tagName": "减",
					"discountType": 0,
					"type": 1,
					"promotionId": 119987
				}],
				"promotionIntro": "活动名称：三亚旅游节立减600/成人再送御泥坊【净透亮颜美丽礼包】1份1、6.13-8.31区间预订该线路指定活动团期（非活动团期不可参加此活动），即可享受立减600/成人，提交订单时，勾选“立减优惠”即可扣减相应金额，保险不含。2、儿童同行不享受优惠政策（儿童标准以途牛旅游网具体产品线路“费用说明”中公布为准）。3、本次活动按双人出行共用一间房核算单人价格，最终成行价格将根据所选出发日期、出行人数、住宿房型、交通以及所选附加服务的不同而有所不同，以客服与您确认需求后核算价格为准。4、本活动名额有限，售完即止，不与途牛旅游网其他任何优惠活动同享（旅游券除外）。5、途牛旅游网在法律允许的范围内保留对本次活动的变更权，包括但不限于参加资格、消费时间及奖励方式、暂停或取消本活动等。6、御泥坊面膜赠品-客户收到途牛发送的兑换码活动信息，扫描二维码进入御泥坊VIP商城，凭借兑换码领取，在御泥坊VIP商城首页的【兑换专区】输入兑换码后，商品自动加入购物车，然后用户下单填写地址即可，用户需自理邮费15元，与其他包邮产品一起购买可免邮。",
				"lowestPriceName": "促销价",
				"mobileOnlyFlag": 0,
				"sharingPromotionId": 0,
				"sharingPreferential": 0,
				"stockInfo": {"stockSign": 1, "stockNum": 3},
				"weekDay": "周六",
				"festival": "",
				"cutPrice": 600
			}, "minPrice": 3439
		},
		"today": "2016-07-25",
		"todayMix": 25,
		"beforeBlankCount": 5,
		"monthDayCount": 31,
		"monthLabel": "2016-07",
		"selectedDate": ""
	};

	var html = Template.calendar(data);
	$('#J_calendar-content').html(html);

	var Calendar = {
		init: function() {
			this.$rootCalendar = $('#J_calendar-content');
			this._bindEvent();
		},
		initByData: function(dates, multiData, selectedDate) {
			if (dates == null ) {
				return;
			}
			this.multiData = multiData;
			this.dates = this._preProcessCalData(dates);
			this._render(this.dates, selectedDate);
		},
		_preProcessCalData: function(caleData) {
			if (TN_DATA.productMode == 2) {
				var resData = {}
					, ymReg = /^(\d{4}\-\d{2})/;
				if (Array.isArray(caleData)) {
					caleData.forEach(function(dateData) {
						if (dateData) {
							var ymLabel = ymReg.exec(dateData.planDate);
							if (ymLabel) {
								ymLabel = ymLabel[1];
								resData[ymLabel] = (resData[ymLabel] || {});
								resData[ymLabel][dateData.planDate] = dateData;
								resData[ymLabel]['minPrice'] = Math.min(dateData.startPrice, resData[ymLabel]['minPrice'] || Infinity);
							}
						}
					});
				}
				return resData;
			} else {
				for (var month in caleData) {
					var monthData = caleData[month];
					for (var day in monthData) {
						monthData['minPrice'] = Math.min(monthData[day].startPrice, monthData['minPrice'] || Infinity);
					}
				}
				return caleData;
			}
		},
		_render: function(dates, defaultSelected) {
			var self = this;
			var selectedMonth = '';
			var selectedDate = '';
			var hasInit = false;
			if (!defaultSelected) {
				for (var s in dates) {
					selectedMonth = s;
					break;
				}
			} else {
				selectedMonth = defaultSelected.substr(0, defaultSelected.length - 3);
			}
			$('#J_calendar-tabs').html(Template('calendarTabs', {
				dates: dates,
				selectedMonth: selectedMonth
			}));
			new ScrollTab({
				contain: '#J_calendar-tabs .tabs',
				itemSelector: '.tab',
				callback: function(dom) {
					var month = $(dom).data('key');
					if (month) {
						self._renderCenter(self.dates[month], month, hasInit ? '' : defaultSelected);
						hasInit = true;
						selectedDate = '';
						self.selectDateChangeFn(selectedDate);
					}
				}
			});
			$('#J_calendar-tabs').find('.tab').each(function(index, dom) {
				if ($(dom).data('key') == selectedMonth) {
					$(dom).trigger('click');
				}
			});
			this.$rootCalendar.on('tap', '.day-td', function(e) {
				if ($(this).hasClass('disabled')) {
					return;
				}
				self.$rootCalendar.find('.day-td').removeClass('selected');
				$(this).addClass('selected');
				selectedDate = $(this).data('key');
				self.selectDateChangeFn(selectedDate);
			});
			selectedDate = defaultSelected;
			if (selectedDate) {
				self.selectDateChangeFn(selectedDate);
			}
		},
		_renderCenter: function(dates, selectedMonth, selectedDate) {
			var html = '';
			var temp = selectedMonth.split('-');
			var year = parseInt(temp[0], 10);
			var month = parseInt(temp[1], 10) - 1;
			var monthFirst = new Date(year,month,1,0,0,0);
			var monthLast = new Date(year,month + 1,0,0,0,0);
			var now = new Date();
			var today = now.getFullYear() + '-' + (now.getMonth() < 9 ? '0' + (now.getMonth() + 1) : now.getMonth() + 1) + '-' + (now.getDate() < 10 ? '0' + now.getDate() : now.getDate());
			html += Template('calendarTemp', {
				dates: dates,
				today: today,
				todayMix: month > now.getMonth() ? 0 : now.getDate(),
				beforeBlankCount: monthFirst.getDay(),
				monthDayCount: monthLast.getDate(),
				monthLabel: selectedMonth,
				selectedDate: selectedDate
			});
			$('#J_calendar-content').html(html);
		},
		selectDateChangeFn: function(selectedDate) {
			if (!selectedDate || !selectedDate.length) {
				Page.refreshPrice(null );
				Page.checkValid();
				$('#J_calendar-promotion').html('');
				return;
			}
			var month = selectedDate.replace(/-\d{1,2}$/, '');
			var priceData = this.dates[month][selectedDate];
			if (priceData == null ) {
				return;
			}
			var journeyArray = [];
			if (this.multiData && this.multiData.multiJourneyFlag && this.multiData.multiJourneyPlanDates) {
				for (var i = 0; i < this.multiData.multiJourneyPlanDates.length; i++) {
					var journey = this.multiData.multiJourneyPlanDates[i];
					if (journey.planDates.indexOf(selectedDate) != -1) {
						journeyArray.push(journey.journeyName);
					}
				}
			}
			$('#J_calendar-promotion').html(Template('calendarPromotion', {
				selectedDate: selectedDate,
				data: priceData,
				journeyText: journeyArray.join('、')
			}));
			Page.refreshPrice(priceData);
			Page.checkValid();
		},
		_bindEvent: function() {
			var self = this;
			$('#J_calendar-promotion').on('tap', '.promotion-title', function() {
				$(this).parents('.promotion').toggleClass('expand');
			});
		},
		getValue: function() {
			return this.$rootCalendar.find('.day-td.selected').data('key');
		},
		checkValid: function() {
			return this.$rootCalendar.find('.day-td.selected').length > 0;
		}
	};

	//return scope;
});
