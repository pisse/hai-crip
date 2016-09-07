var mySwiper = new Swiper(".swiper-container", {
	direction: "vertical",
	// noSwiping: true,
	followFinger : false,
	slideActiveClass: "cur",
	onSlideChangeEnd: function(a) {
		var b = a.activeIndex;
		if (b===0) {
			$('.arrow').addClass('arrow1');
		}else{
			$('.arrow').removeClass('arrow1');
		}
		if (b === 1) {
			chart1()
		}
		if (b === 2) {
			chart2()
		}
		if (b === 3) {
			chart3()
		}
		if (b === 5) {
			chart4()
		}
		if (b === 7) {
			chart5()
		}
		if (b === 14) {
			$(".arrow").hide()
		} else {
			$(".arrow").show()
		}
	}
	// onSlideChangeEnd: function(a) {
	// 	$(".swiper-slide").addClass("swiper-no-swiping");
	// 	setTimeout("$('.swiper-slide').removeClass('swiper-no-swiping')", 1000)
	// }
});

function chart1() {
	$(".chart1").highcharts({
		chart: {
			zoomType: "xy"
		},
		title: {
			text: "季度成交金额与成交笔数",
			style: {
				fontSize: "14px"
			}
		},
		subtitle: {
			text: null
		},
		xAxis: [{
			categories: ["1季度", "2季度", "3季度", "4季度"]
		}],
		yAxis: [{
			labels: {
				format: "{value}",
				style: {
					color: "#333333"
				}
			},
			title: {
				text: "成交笔数<br>（万笔）",
				align: "high",
				offset: -10,
				rotation: 0,
				y: -30,
				style: {
					color: "#333333",
					fontSize: "12px"
				}
			}
		}, {
			title: {
				text: "成交金额<br>（亿元）",
				align: "high",
				offset: -10,
				rotation: 0,
				y: -30,
				style: {
					color: "#333333",
					fontSize: "12px"
				}
			},
			labels: {
				format: "{value}",
				style: {
					color: "#333333",
				}
			},
			opposite: true
		}],
		tooltip: false,
		series: [
		{
			enableMouseTracking: false,
			name: "成交笔数（万笔）",
			color: "#4572A7",
			type: "column",
			data: [4.12, 16.51, 42.62, 52.41],
			events: {
				legendItemClick: function() {
					return false
				}
			}
		},{
			enableMouseTracking: false,
			name: "成交金额（亿元）",
			color: "#f7941d",
			type: "spline",
			yAxis: 1,
			data: [1.68, 8.28, 21.54, 29.08],
			events: {
				legendItemClick: function() {
					return false
				}
			}
		} ],
		credits: {
			enabled: false
		}
	})
}

function chart2() {
	$(".chart2").highcharts({
		chart: {
			zoomType: "xy"
		},
		title: {
			text: "季度还款金额与发放收益",
			style: {
				color: "#333333",
				fontSize:'14px'
			}
		},
		subtitle: {
			text: null
		},
		xAxis: [{
			categories: ["1季度", "2季度", "3季度", "4季度"]
		}],
		yAxis: [{
			labels: {
				format: "{value}",
				style: {
					color: "#333333"
				}
			},
			title: {
				text: "还款金额<br>（亿元）",
				align: "high",
				offset: -10,
				rotation: 0,
				y: -30,
				margin: 0,
				style: {
					color: "#333333",
					fontSize: "12px"
				}
			}
		}, {
			title: {
				text: "收益金额<br>（千万）",
				align: "high",
				offset: -10,
				rotation: 0,
				y: -30,
				margin: 0,
				style: {
					color: "#333333",
					fontSize: "12px"
				}
			},
			labels: {
				format: "{value}",
				style: {
					color: "#333333"
				}
			},
			opposite: true
		}],
		tooltip: false,
		series: [{
			enableMouseTracking: false,
			name: "还款金额（亿元）",
			color: "#ffbc71",
			type: "column",
			yAxis: 1,
			data: [0.52, 4.33, 12.93, 23.16],
			events: {
				legendItemClick: function() {
					return false
				}
			}
		}, {
			enableMouseTracking: false,
			name: "累计收益（万笔）",
			color: "#f26522",
			type: "spline",
			data: [0.2, 1.17, 3.37, 4.95],
			events: {
				legendItemClick: function() {
					return false
				}
			}
		}],
		credits: {
			enabled: false
		}
	})
}

function chart3() {
	$(".chart3").highcharts({
		chart: {
			type: "column"
		},
		title: {
			text: "季度新增用户",
			style: {
				color: "#333333",
				fontSize:'14px'
			}
		},
		subtitle: {
			text: null
		},
		xAxis: {
			categories: ["1季度", "2季度", "3季度", "4季度"]
		},
		yAxis: {
			min: 0,
			title: {
				text: "新增用户数<br />（万人）",
				align: "high",
				offset: -10,
				rotation: 0,
				y: -30,
				margin: 0
			}
		},
		tooltip: false,
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0,
				events: {
					legendItemClick: function() {
						return false
					}
				}
			}
		},
		series: [{
			enableMouseTracking: false,
			name: "新增用户数",
			color: "#f45555",
			data: [7.45, 33.02, 106.78, 149.51]
		}],
		credits: {
			enabled: false
		}
	})
}

function chart4() {
	$(".chart4").highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: null
		},
		tooltip: false,
		plotOptions: {
			pie: {
				allowPointSelect: false,
				cursor: "pointer",
				dataLabels: {
					enabled: true,
					color: "#000000",
					connectorColor: "#000000",
					format: "{point.percentage:.1f} %"
				},
				showInLegend: true,
				colors: ["#e76f34", "#b3d4d9", "#9b8578", "#c6d861", "#58c5bf"],
				point: {
					events: {
						legendItemClick: function() {
							return false
						}
					}
				}
			}
		},
		series: [{
			enableMouseTracking: false,
			type: "pie",
			name: null,
			data: [
				["1个月以内", 0.18],
				["1~3个月", 0.32],
				["3~6个月", 0.19],
				["6~12个月", 0.24],
				["12个月以上", 0.07],
			]
		}],
		credits: {
			enabled: false
		}
	})
}

function chart5() {
	$(".chart5").highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: null
		},
		tooltip: {
			pointFormat: "{point.percentage:.1f}%</b>"
		},
		plotOptions: {
			pie: {
				innerSize: "60",
				cursor: "pointer",
				dataLabels: {
					enabled: true,
					color: "#000000",
					connectorColor: "#000000",
					format: "{point.percentage:.1f} %"
				},
				showInLegend: true,
				colors: ["#a4c8cc", "#bccf57", "#4cbdb6", "#8d7468", "#e45f2d"],
				point: {
					events: {
						legendItemClick: function() {
							return false
						}
					}
				}
			}
		},
		series: [{
			type: "pie",
			name: null,
			data: [
				["90后", 0.29],
				["80后", 0.41],
				["70后", 0.22],
				["60后", 0.05],
				["其他", 0.03]
			]
		}],
		credits: {
			enabled: false
		}
	})
};