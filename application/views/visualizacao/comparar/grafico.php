<section class="graph container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="section-title">
					<h2>
						Contexto de Interesse: <?php echo $contextointeresse[0]['nome']; ?>
						Sensor: <?php echo $sensor[0]['nome']; ?>
					</h2>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-xs-12">
				<div id="chart"></div>
			</div>
		</div>
		<script type="text/javascript">
	    	$(document).ready(function(){
	    		$('#chart').highcharts("StockChart", {
			        chart: {
			        	zoomType: 'x'
			        },
			        credits: {
                        enabled: false
                    },
			        title: {
			            text : '<?php echo $contextointeresse[0]['nome']." > ".$sensor[0]['nome']; ?>'
			        },
			        xAxis: {
			            type: 'datetime',
	                    ordinal: false,
			        },
			        navigator: {
	                    xAxis: {
	                        ordinal: false
	                    }
	                },
			        yAxis: {
			        	title: {
			                text: '<?php echo $sensor[0]["nome"]." (".$sensor[0]["unidade"].")" ?>'
			            },
                        min: <?php echo $sensor[0]["valormin"] ?>,
                        max: <?php echo $sensor[0]["valormax"] ?>,
			            labels: {
                            formatter: function() {
                                return (this.value > 0 ? '+' : '') + this.value + '<?php echo $sensor[0]["unidade"]; ?>';
                            }
                        },
                        plotLines: [
                        	{
                                value: <?php echo $sensor[0]["valormin"] ?>,
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
                                value: <?php echo $sensor[0]["valormax"] ?>,
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
                        ]				            
			        },
			        tooltip: {
                        valueDecimals: 2,
                        valueSuffix: '<?php echo $sensor[0]["unidade"] ?>'
                    },
			        series: <?php echo $serie ?>

		    	});
	        });
	    </script>
	</div>
</section>