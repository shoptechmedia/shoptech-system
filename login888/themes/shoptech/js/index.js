$(function(e) {

	var stepSize = parseInt(graphs.orders.header.length / 10);

	var applySkip = function(stepSize, array){

		var newArr = [];

		$.each(array, function(i, arr){
			var skippable = (i % stepSize);

			if(!skippable || (i+1) == array.length)
				newArr.push(arr);
		});

		return newArr;

	}

	var headers = applySkip(stepSize, graphs.orders.header);
	var orders = applySkip(stepSize, graphs.orders.value);
	var sales = applySkip(stepSize, graphs.sales.value);
	var net_profits = applySkip(stepSize, graphs.net_profits.value);

	/*---ChartJS (#barChart)---*/
	var ctx = document.getElementById("barChart");
	ctx.height = "260";
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: headers,
			datasets: [{
				label: "Total Orders",
				data: orders,
				borderColor: "rgba(142, 156, 173,0.2)",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#0052cc"
			},{
				label: "Total Sales",
				data: sales,
				borderColor: "rgba(142, 156, 173,0.2)",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#8c8eef"
			}, {
				label: "Total Profits",
				data: net_profits,
				borderColor: "rgba(142, 156, 173,0.2)",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#b7b9ec"
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "#8e9cad"
					 },
					gridLines: {
						color: 'rgba(142, 156, 173,0.2)',
						display: true,
					}
				}],
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: "#8e9cad",
					},
					gridLines: {
						color: 'rgba(142, 156, 173,0.2)',
						display: true
					},
				}]
			},
			legend: {
				labels: {
					fontColor: "#8e9cad"
				},
			},
		}
	});

});