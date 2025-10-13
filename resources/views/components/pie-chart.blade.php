<div>
	<div class="card">
		<div class="card-header">
			<h4>{{ $chartTitle }}</h4>
		</div>
		<div class="card-body">
			<div id="{{ $chartID }}"></div>
		</div>
	</div>
</div>

@push('js')
<script>
	$(function() {
		const chartID = "#{{ $chartID }}";
		const categories = @json($categories);
		const series = @json($series);

		let options = {
			series: series,
			chart: {
				height: 320,
				type: "donut", // ganti pie -> donut
			},
			labels: categories,
			legend: {
				position: "bottom",
				fontSize: "13px",
				labels: {
					colors: "#333"
				}
			},
			dataLabels: {
				enabled: true,
				formatter: function(val, opts) {
					// tampilkan persentase + value
					return opts.w.config.series[opts.seriesIndex] + " (" + val.toFixed(1) + "%)";
				}
			},
			tooltip: {
				y: {
					formatter: function(val) {
						return val + " data"; // bisa diganti satuan
					}
				}
			},
			plotOptions: {
				pie: {
					donut: {
						size: "60%", // ukuran tengah donut
						labels: {
							show: true,
							total: {
								show: true,
								label: "Total",
								formatter: function(w) {
									return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
								}
							}
						}
					}
				}
			},
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 240
					},
					legend: {
						position: "bottom"
					}
				}
			}]
		};

		@isset($colors)
		options.colors = @json($colors)
		@endisset

		new ApexCharts(document.querySelector(chartID), options).render();
	});
</script>
@endpush