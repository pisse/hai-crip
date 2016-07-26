/* global define */
define([
	"zepto"
], function ($) {
	'use strict';
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

	return scope;
});
