/*
Template Name: STUDIO - Responsive Bootstrap 5 Admin Template
Version: 3.0.0
Author: Sean Ngu
*/

var lineChart, barChart, radarChart, polarAreaChart, pieChart, doughnutChart;

var handleRenderChartJs = function() {
	Chart.defaults.font.family = app.font.family;
	Chart.defaults.color = app.color.componentColor;
	Chart.defaults.plugins.legend.display = false;
	Chart.defaults.plugins.tooltip.padding = 8;
	Chart.defaults.plugins.tooltip.backgroundColor = 'rgba('+ app.color.componentColorRgb + ', .95)';
	Chart.defaults.plugins.tooltip.titleFont.family = app.font.family;
	Chart.defaults.plugins.tooltip.titleFont.weight = 600;
	Chart.defaults.plugins.tooltip.footerFont.family = app.font.family;
	Chart.defaults.scale.grid.color = 'rgba('+ app.color.componentColorRgb + ', .15)';
	
	var ctx = document.getElementById('lineChart');
	lineChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
			datasets: [{
				color: app.color.blue,
				backgroundColor: 'rgba('+ app.color.blue +', .2)',
				borderColor: app.color.blue,
				borderWidth: 1.5,
				pointBackgroundColor: app.color.componentBg,
				pointBorderWidth: 1.5,
				pointRadius: 4,
				pointHoverBackgroundColor: app.color.blue,
				pointHoverBorderColor: app.color.white,
				pointHoverRadius: 7,
				label: 'Total Sales',
				data: [12, 19, 4, 5, 2, 3]
			}]
		}
	});
	
	var ctx2 = document.getElementById('barChart');
	barChart = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: ['Jan','Feb','Mar','Apr','May','Jun'],
			datasets: [{
				label: 'Total Visitors',
				data: [37,31,36,34,43,31],
				backgroundColor: 'rgba('+ app.color.blue +', .2)',
				borderColor: app.color.blue,
				borderWidth: 1.5
			},{
				label: 'New Visitors',
				data: [12,16,20,14,23,21],
				backgroundColor: 'rgba('+ app.color.gray500Rgb + ', .2)',
				borderColor: app.color.gray500,
				borderWidth: 1.5
			}]
		}
	});
	
	var ctx3 = document.getElementById('radarChart');
	radarChart = new Chart(ctx3, {
		type: 'radar',
		data: {
			labels: ['United States', 'Canada', 'Australia', 'Netherlands', 'Germany', 'New Zealand', 'Singapore'],
			datasets: [
				{
					label: 'Mobile',
					backgroundColor: 'rgba('+ app.color.blueRgb + ', .2)',
					borderColor: app.color.blue,
					pointBackgroundColor: app.color.white,
					pointBorderColor: app.color.blue,
					pointHoverBackgroundColor: app.color.blue,
					pointHoverBorderColor: app.color.white,
					data: [65, 59, 90, 81, 56, 55, 40],
					borderWidth: 1.5
				},
				{
					label: 'Desktop',
					backgroundColor: 'rgba('+ app.color.gray500Rgb +', .2)',
					borderColor: app.color.gray500,
					pointBackgroundColor: app.color.white,
					pointBorderColor: app.color.gray500,
					pointHoverBackgroundColor: app.color.gray500,
					pointHoverBorderColor: app.color.white,
					data: [28, 48, 40, 19, 96, 27, 100],
					borderWidth: 1.5
				}
			]
		}
	});
	
	var ctx4 = document.getElementById('polarAreaChart');
	polarAreaChart = new Chart(ctx4, {
		type: 'polarArea',
		data: {
			datasets: [{
				data: [11, 16, 7, 3, 14],
				backgroundColor: ['rgba('+ app.color.blueRgb + ', .85)', 'rgba('+ app.color.indigoRgb +', .85)', 'rgba('+ app.color.cyanRgb +', .85)',  'rgba('+ app.color.gray500Rgb +', .85)', 'rgba('+ app.color.gray800Rgb +', .85)'],
				borderWidth: 0
			}],
			labels: ['IE', 'Safari', 'Chrome', 'Firefox', 'Opera']
		}
	});
	
	var ctx5 = document.getElementById('pieChart');
	pieChart = new Chart(ctx5, {
		type: 'pie',
		data: {
			labels: ['Total Visitor', 'New Visitor', 'Returning Visitor'],
			datasets: [{
				data: [300, 50, 100],
				backgroundColor: [app.color.blue, app.color.indigo, app.color.gray900],
				hoverBackgroundColor: [app.color.blue, app.color.indigo, app.color.gray900],
				borderWidth: 0
			}]
		}
	});
	
	var ctx6 = document.getElementById('doughnutChart');
	doughnutChart = new Chart(ctx6, {
		type: 'doughnut',
		data: {
			labels: ['Total Visitor', 'New Visitor', 'Returning Visitor'],
			datasets: [{
				data: [300, 50, 100],
				backgroundColor: [app.color.blue, app.color.indigo, app.color.gray900],
				hoverBackgroundColor: [app.color.blue, app.color.indigo, app.color.gray900],
				borderWidth: 0
			}]
		}
	});
};

/* Controller
------------------------------------------------ */
$(document).ready(function() {
	handleRenderChartJs();
	
	$(document).on('theme-change', function() {
		lineChart.destroy();
		barChart.destroy();
		radarChart.destroy();
		polarAreaChart.destroy();
		pieChart.destroy();
		doughnutChart.destroy();
		
		handleRenderChartJs();
	});
});