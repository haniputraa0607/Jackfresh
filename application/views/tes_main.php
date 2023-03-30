<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="card shadow mb-4">
    <div class="card-body">
		<div class="row">

			<!-- Pendapatan Per Hari Filter Tanggal-->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									Pendapatan (Per-Hari)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Rp '.number_format((int)$data['today_income'],0,",",".") ?></div>
							</div>
							<div class="col-auto">
								<i id="date-range-picker-btn" class="fas fa-calendar fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Pendapatan Per Hari Filter Bulan, jika sudah filter tgl, bulan mengikuti tgl itu saja -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
									Peendapatan (Per-Bulan)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Rp '.number_format((int)$data['month_income'],0,",",".") ?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Pendapatan Total -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
									Peendapatan Total</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Rp '.number_format((int)$data['total_income'],0,",",".") ?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Transaksi Filter Mengikuti yg sudah difilter -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-warning shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
									Total Transaksi</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['total_transaction']; ?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-comments fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		

		<div class="row">
			
			<!-- Area Chart -->
			<div class="col-xl-12 col-lg-7">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div
						class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Report Pendapatan Per Bulan (Total Cash & Tempo)</h6>
						<div class="dropdown no-arrow">
						   
							
						</div>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="chart-area">
							<canvas id="myAreaChart"></canvas>
						</div>
					</div>
				</div>
			</div>

			
		</div>

		<div class="row">

			<!-- Content Column -->
			<div class="col-lg-12 mb-4">

				<!-- Project Card Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">Pelanggan</h6>
					</div>
					<div class="card-body">
						<!-- <h4 class="small font-weight-bold">Resto A <span
								class="float-right">Total Transaksi (Dalam Rupiah)</span></h4>
						<div class="progress mb-4">
							<div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
								aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<h4 class="small font-weight-bold">Resto B <span
								class="float-right">40%</span></h4>
						<div class="progress mb-4">
							<div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
								aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<h4 class="small font-weight-bold">Customer Database <span
								class="float-right">60%</span></h4>
						<div class="progress mb-4">
							<div class="progress-bar" role="progressbar" style="width: 60%"
								aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<h4 class="small font-weight-bold">Payout Details <span
								class="float-right">80%</span></h4>
						<div class="progress mb-4">
							<div class="progress-bar bg-info" role="progressbar" style="width: 80%"
								aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<h4 class="small font-weight-bold">Account Setup <span
								class="float-right">Complete!</span></h4>
						<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: 100%"
								aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
						</div> -->
						<?php foreach ($data['client_transaction'] ?? [] as $key => $client) : ?>
							<?php 
								$color = '';
								$pers = ($client->total_transaction / $data['month_income'] *100);
								if($key+1 == 1 || (($key+1)%5 == 1)){
									$color = 'bg-danger';
								}elseif($key+1 == 2 || (($key+1)%5 == 2)){
									$color = 'bg-warning';
								}elseif($key+1 == 3 || (($key+1)%5 == 3)){
									$color = '';
								}elseif($key+1 == 4 || (($key+1)%5 == 4)){
									$color = 'bg-info';
								}elseif($key+1 == 5 || (($key+1)%5 == 0)){
									$color = 'bg-success';
								}
							?>
							<h4 class="small font-weight-bold"><?= $client->client_name; ?><span
									class="float-right"><?= 'Rp '.number_format((int)$client->total_transaction,0,",","."); ?></span></h4>
							<div class="progress mb-4">
								<div class="progress-bar <?= $color; ?>" role="progressbar" style="width: <?= $pers; ?>%"
									aria-valuenow="<?= $pers; ?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
   	 </div>
</div>

<script src="<?php echo base_url() ?>assets/vendor/chart.js/Chart.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">

	$(function() {
		$('#date-range-picker-btn').daterangepicker({
			opens: 'right'
		}, function(start, end, label) {
			console.log("A date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});

	
	// Set new default font family and font color to mimic Bootstrap's default styling
	(Chart.defaults.global.defaultFontFamily = "Nunito"),
		'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	Chart.defaults.global.defaultFontColor = "#858796";

	function number_format(number, decimals, dec_point, thousands_sep) {
		// *     example: number_format(1234.56, 2, ',', ' ');
		// *     return: '1 234,56'
		number = (number + "").replace(",", "").replace(" ", "");
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = typeof thousands_sep === "undefined" ? "." : thousands_sep,
			dec = typeof dec_point === "undefined" ? "," : dec_point,
			s = "",
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return "" + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || "").length < prec) {
			s[1] = s[1] || "";
			s[1] += new Array(prec - s[1].length + 1).join("0");
		}
		return s.join(dec);
	}

	

	// Area Chart Example
	var xav = [<?php echo '"'.implode('","', $data['income_permonth']).'"' ?>];
	var ctx = document.getElementById("myAreaChart");
	var myLineChart = new Chart(ctx, {
		type: "line",
		data: {
			labels: [
				"Jan",
				"Feb",
				"Mar",
				"Apr",
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec",
			],
			datasets: [
				{
					label: "Earnings",
					lineTension: 0.3,
					backgroundColor: "rgba(78, 115, 223, 0.05)",
					borderColor: "rgba(78, 115, 223, 1)",
					pointRadius: 3,
					pointBackgroundColor: "rgba(78, 115, 223, 1)",
					pointBorderColor: "rgba(78, 115, 223, 1)",
					pointHoverRadius: 3,
					pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
					pointHoverBorderColor: "rgba(78, 115, 223, 1)",
					pointHitRadius: 10,
					pointBorderWidth: 2,
					data: xav,
				},
			],
		},
		options: {
			maintainAspectRatio: false,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 25,
					bottom: 0,
				},
			},
			scales: {
				xAxes: [
					{
						time: {
							unit: "date",
						},
						gridLines: {
							display: false,
							drawBorder: false,
						},
						ticks: {
							maxTicksLimit: 7,
						},
					},
				],
				yAxes: [
					{
						ticks: {
							maxTicksLimit: 5,
							padding: 10,
							// Include a dollar sign in the ticks
							callback: function (value, index, values) {
								return number_format(value);
							},
						},
						gridLines: {
							color: "rgb(234, 236, 244)",
							zeroLineColor: "rgb(234, 236, 244)",
							drawBorder: false,
							borderDash: [2],
							zeroLineBorderDash: [2],
						},
					},
				],
			},
			legend: {
				display: false,
			},
			tooltips: {
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				titleMarginBottom: 10,
				titleFontColor: "#6e707e",
				titleFontSize: 14,
				borderColor: "#dddfeb",
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				intersect: false,
				mode: "index",
				caretPadding: 10,
				callbacks: {
					label: function (tooltipItem, chart) {
						var datasetLabel =
							chart.datasets[tooltipItem.datasetIndex].label || "";
						return datasetLabel + ": " + number_format(tooltipItem.yLabel);
					},
				},
			},
		},
	});


</script>
