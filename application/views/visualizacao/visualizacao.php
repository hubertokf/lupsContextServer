<section class="visualizacao">
	<div class="container">
		<form id="form" action="<?php echo base_url(); ?>index.php/CI_visualizacao/tabela" class="form-contextointeresse" method="post">
			<div class="row">
				<div class="col-sm-6" style="display: none;">
					<div class="borda">
						<div class="row">
							<div class="col-xs-12">
								<label for="contextointeresse">Local</label>	
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<select id="contextointeresse-value" name="contextointeresse">
									<option value="" selected="" disabled="">Selecione</option>
									<?php
										$selected = "";
										foreach ($contextos_interesse as $ci) {
											if(isset($_SESSION['contextointeresse']))
												if ($ci["contextointeresse_id"]==$_SESSION['contextointeresse']){
													$selected = "selected";
												}
											echo '<option value="'.$ci['contextointeresse_id'].'" '.$selected.'>'.$ci['nome'].'</option>';
											$selected = "";
										}
									?>
								</select>
							</div><!-- /.col-xs-12 -->
						</div><!-- /.row -->
					</div><!-- /.borda -->				
				</div><!-- /.col-lg-6 -->
				<div class="col-sm-offset-3 col-sm-6">
					<div class="sensor">
						<div class="row">
							<div class="col-xs-12">
								<label for="sensor">Sensor</label>
							</div><!-- /.col-xs-12 -->
						</div><!-- /.row -->
						<div class="row">
							<div class="col-xs-12">
								<select name="sensor"  id="sensor-value-self">
									<option value="" selected="" disabled="">Selecione</option>
									<?php
										$selected = "";
										foreach ($sensores->result_array() as $s) {
											if(isset($_SESSION['sensor']))
												if ($s["sensor_id"]==$_SESSION['sensor']){
													$selected = "selected";
												}
											echo '<option value="'.$s['sensor_id'].'" '.$selected.'>'.$s['nome'].'</option>';
											$selected = "";
										}
									?>
								</select>
							</div><!-- /.col-xs-12 -->
						</div><!-- /.row -->
					</div><!-- /.sensor -->
				</div><!-- /.col-lg-6 -->
			</div><!-- /.row -->

			<div class="row">
				<div class="submit">
					<div class="col-sm-4 col-md-2 col-md-offset-5 col-sm-offset-4">
						<input class="submit-coletor" name='Submit' type='submit' value='Continuar' />
					</div><!-- /.col-lg-2 col-lg-offset-5 -->					
				</div>
			</div><!-- /.row -->
			
		</form>
	</div>
</section><!-- /.main -->
