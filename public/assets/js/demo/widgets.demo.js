/*
Template Name: STUDIO - Responsive Bootstrap 5 Admin Template
Version: 3.0.0
Author: Sean Ngu
*/

var handleRenderChartJs = function() {
	Chart.defaults.color = app.color.white;
	Chart.defaults.font.size = 12;
	Chart.defaults.font.weight = 'bold';
	
	var ctx = document.getElementById('barChart');
	var barChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['S','M','T','W','T','F','S'],
			datasets: [{
				label: 'Total Visitors',
				data: [37,31,36,34,43,31,50],
				backgroundColor: hexToRgba(app.color.gray900, .5),
				borderColor: 'transparent'
			}]
		},
		options: {
			legend: {
				display: false
			},
			tooltips: {
				callbacks: {
					title: function(tooltipItems, data) { 
						var tooltipTitle = '';
						switch (tooltipItems[0].index) {
							case 0: tooltipTitle = 'Sunday'; break;
							case 1: tooltipTitle = 'Monday'; break;
							case 2: tooltipTitle = 'Tuesday'; break;
							case 3: tooltipTitle = 'Wednesday'; break;
							case 4: tooltipTitle = 'Thursday'; break;
							case 5: tooltipTitle = 'Friday'; break;
							case 6: tooltipTitle = 'Saturday'; break;
						}
						return tooltipTitle;
					},
					labelColor: function(tooltipItem, chart) {
						return {
							borderColor: 'transparent',
							backgroundColor: hexToRgba(app.color.white, .5)
						};
					}
				}
			},
			scales: {
				yAxes: [{
					gridLines: {
						borderDashOffset: 5,
						drawTicks: false,
						drawBorder: false,
						borderDash: [4]
					},
					ticks: {
						display: false
					}
				}],
				xAxes: [{
					barPercentage: 0.4,
					gridLines : {
						display : false
					}
				}]
			}
		}
	});
};


/* Init Demo
------------------------------------------------ */
$(document).ready(function() {
	handleRenderChartJs();
});