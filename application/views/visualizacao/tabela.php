<section class="tab container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="section-title">
					<h2>
						<!-- Contexto de Interesse: <?php //echo $contextointeresse[0]['nome']; ?> -->
						Sensor: <?php echo $sensor[0]['nome']; ?>
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="dados seven-cols row">
					<?php 
						foreach ($dias as $i=>$dia) {
							if (!empty($dia)){
					?>
					<div class="col-sm-1">
						<table class="tabela">
					        <thead>
					            <tr>
					                <th scope="col" colspan="2"><?php echo date('d/m', strtotime($dia[0]['datacoleta'])); ?></th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php if($sensor[0]['tiposensor_id'] != 11) {?>
							        <tr class="medias">
							        	<td class="leg"><span>Méd.</span></td>
							        	<td><?php echo number_format($meds[$i][0]['valor_med'], 2, ',', '.')." ".$dia[0]['tiposensor_unidade']; ?></td>
							        </tr>
							        <tr class="medias">
							        	<td class="leg"><span>Máx.</span></td>
							        	<td><?php echo number_format($meds[$i][0]['valor_max'], 2, ',', '.')." ".$dia[0]['tiposensor_unidade']; ?></td>
							        </tr>
							        <tr class="medias">
							        	<td class="leg"><span>Mín.</span></td>
							        	<td><?php echo number_format($meds[$i][0]['valor_min'], 2, ',', '.')." ".$dia[0]['tiposensor_unidade']; ?></td>
							        </tr>
							        <tr class="medias">
							        	<td class="divider" colspan="2">&nbsp;</td>
						        	</tr>
						        <?php } ?>
			                	<?php 
				                	foreach ($dia as $dado) {
				                		echo "<tr>";
				                		echo "<td>".Date("G:i",strtotime($dado['datacoleta']))."</td>";
				                		if($sensor[0]['tiposensor_id'] != 11) {
				                			echo "<td>".number_format($dado['valorcoletado'], 2, ',', '.')." ".$dado['tiposensor_unidade']."</td>";
				                		}else{
				                			echo "<td>".number_format($dado['valorcoletado'], 0, ',', '.')." ".$dado['tiposensor_unidade']."</td>";
				                		}
				                		echo "</tr>";
				                	}
			                	?>
            				</tbody>
						</table>
					</div>
					<?php 
						}
					}
					?>
				</div>
			</div>			
		</div><!-- /.row -->
	</div><!-- /.container -->
</section>