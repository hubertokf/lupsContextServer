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
		<?php } ?>


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
				for (var i=data.length-1; i>=0; i--) {
				    tmp = data[i].minvalue;
				    tmp2 = data[i].maxvalue;
				    if (tmp < minvalue) minvalue = tmp;
				    if (tmp2 > maxvalue) maxvalue = tmp2;
				}
				Highcharts.setOptions({
			        global: {
			            timezoneOffset: 2 * 60
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
			        tooltip: {pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                        valueDecimals: 2
                    },
			        series: <?php echo $serie ?>

		    	});
	        });
	    </script>
	</div>
</section>