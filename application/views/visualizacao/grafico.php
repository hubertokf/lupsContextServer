<section class="graph container-fluid">
	<div class="container">
		<?php $cinome = ""; if (isset($contextointeresse)){ $cinome = $contextointeresse[0]['nome']; ?> 
		<div class="row">
			<div class="col-xs-12">
				<div class="section-title">
					<!--h2>
						Contexto de Interesse: <?php echo $contextointeresse[0]['nome']; ?>
						Sensor: <?php echo $sensor[0]['nome']; ?>
					</h2-->
				</div>
			</div>
		</div>
		<?php } 
		// pegar a diferença de timezone para o brasil. GMT-3 <-
		$dateTimeZone = new DateTimeZone("America/Sao_Paulo");
		$dateTime = new DateTime("now", $dateTimeZone);
		$timeOffset = (($dateTimeZone->getOffset($dateTime)*-1)/60);

		?>


		<div class="row">
			<div class="col-xs-12">
				<div id="chart"></div>
			</div>
		</div>
		<script type="text/javascript">
	    	$(document).ready(function(){
	    		var minvalue = Number.POSITIVE_INFINITY;
				var maxvalue = Number.NEGATIVE_INFINITY;
				var tmp;
				var data = <?php echo $serie; ?>;
				console.log(data);
				for (var i=data.length-1; i>=0; i--) {
				    tmp = data[i].minvalue;
				    tmp2 = data[i].maxvalue;
				    if (tmp < minvalue) minvalue = tmp;
				    if (tmp2 > maxvalue) maxvalue = tmp2;
				}
				Highcharts.setOptions({
			        global: {
			            timezoneOffset: <?php echo $timeOffset; ?>
			        }
			    });
				
	    		$('#chart').highcharts("StockChart", {
			        chart: {
			        	zoomType: 'x'
			        },
			        credits: {
                        enabled: false
                    },
			        title: {
			            text : '<?php echo $cinome."<br>".implode(", ", array_map(function ($e) {return $e["nome"];}, $sensor)); ?>'
			        },
			        xAxis: {
			            type: 'datetime',
	                    ordinal: false,
			        },
			        yAxis: {
			        	/*title: {
			                text: '<?php echo $sensor[0]["nome"]." (".$sensor[0]["unidade"].")" ?>'
			            },*/
                        /*min: minvalue,
                        max: maxvalue,
                        plotLines: [
                        	{
                                value: minvalue,
                                color: 'yellow',
                                width: 1,
                                dashStyle: 'dash',
                                id: 'Mín',
                                zIndex: 1,
                                label: {
                                    text: 'Mín',
                                    align: 'right',
                                    y: 12,
                                    x: 0
                                }
                            },{
                                value: maxvalue,
                                color: 'red',
                                width: 1,
                                dashStyle: 'dash',
                                id: 'Max',
                                zIndex: 1,
                                label: {
                                    text: 'Max',
                                    align: 'right',
                                    y: -4,
                                    x: 0
                                }
                            }
                        ]	*/			            
			        },
					rangeSelector: {
						allButtonsEnabled: true,
						buttons: [
							{
								type: 'day',
								count: 1,
								text: 'Day',
								dataGrouping: {
									forced: true,
									units: [['day', [1]]]
								}
							}, {
								type: 'week',
								count: 1,
								text: 'Week',
								dataGrouping: {
									forced: true,
									units: [['week', [1]]]
								}
							}, {
								type: 'all',
								text: 'All',
								dataGrouping: {
									forced: true,
									units: [['month', [1]]]
								}
							}
						],
						buttonTheme: {
							width: 60
						},
						selected: 2
					},
			        tooltip: {pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                        valueDecimals: 2
                    },
			        series: <?php echo $serie ?>

		    	});
	        });
	    </script>
	</div>
</section>