<section class="compara cadastros container-fluid">
	<div class="container">
		<form name="formComparar" id="formComparar" method="post" action="./comparaGrafico">
			<div class="row">
				<div class="col-xs-12">
					<div class="section-title">
						<h2>
							Contexto de Interesse: <?php echo $contextointeresse[$_SESSION['contextointeresse']]['nome']; ?>
						</h2>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-xs-12">
					<p>Selecione os sensores que deseja comparar:</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 center-box"> 
					<div class="row">
					<?php 

					foreach ($contextointeresse[$_SESSION['contextointeresse']]['sensores'] as $key => $sensor) {
					?>
						
						<div class="col-sm-6 col-xs-12">
							<label><input type="checkbox" name="sensor[]" value="<?php echo $sensor['sensor_id']; ?>"> <?php echo $sensor['sensor_nome']; ?></label>
						</div>

					<?php
						if ($key != (count($contextointeresse[$_SESSION['contextointeresse']]['sensores'])-1) && ($key%2 != 0))
							echo "</div><div class='row'>";
					}

					?>
					</div>

					<div class="row">
		                <div class="submit">
		                    <div class="col-md-6 col-md-offset-3">
		                        <input type="submit" name="botao" value="Comparar" />
		                    </div>          
		                </div>
		            </div>
				</div>
			</div>
		</form>
	</div>
</section>