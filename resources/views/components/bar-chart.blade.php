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
			chart: {
				height: 325,
				type: "bar",
				toolbar: {
					show: true
				}
			},
			plotOptions: {
				bar: {
					horizontal: false, // ubah ke true kalau mau horizontal
					columnWidth: "45%", // lebar bar
					endingShape: "rounded", // bentuk ujung bar: rounded, flat
					borderRadius: 6
				}
			},
			dataLabels: {
				enabled: true, // munculkan angka di atas bar
				style: {
					colors: ['#fff']
				},
				formatter: function(val) {
					return val.toFixed(0); // angka bulat
				}
			},
			stroke: {
				show: true,
				width: 2,
				colors: ["transparent"]
			},
			series: [{
				name: "Jumlah",
				data: series
			}],
			xaxis: {
				categories: categories,
				labels: {
					style: {
						fontSize: "13px"
					}
				}
			},
			yaxis: {
				title: {
					text: "Total"
				},
				labels: {
					formatter: function(val) {
						return val.toFixed(0);
					}
				}
			},
			fill: {
				opacity: 0.9,
				type: "gradient",
				gradient: {
					shade: 'light',
					type: "vertical",
					shadeIntensity: 0.25,
					gradientToColors: undefined,
					inverseColors: true,
					opacityFrom: 0.85,
					opacityTo: 0.95,
					stops: [50, 0, 100]
				}
			},
			tooltip: {
				y: {
					formatter: function(val) {
						return val + " data"; // bisa custom satuan
					}
				}
			}
		};


		@isset($colors)
		options.colors = @json($colors)
		@endisset

		new ApexCharts(document.querySelector(chartID), options).render();
	});
</script>
@endpush