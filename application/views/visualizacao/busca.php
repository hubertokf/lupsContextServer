<section class="busca container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="section-title">
					<h2>Ferramenta de Busca</h2>
				</div>
			</div>
		</div>
		<div class="row ranges">
			<div class="col-sm-offset-3 col-sm-3">
				<div class="row">
					<div class="col-xs-12"><label for="dataInicial">Data Inicial</label></div>
				</div>
				<div class="row">
					<div class="col-xs-12"><input readonly="readonly" type="text" id="dataInicial" class="date"/></div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-xs-12"><label for="dataFinal">Data Final</label></div>
				</div>
				<div class="row">
					<div class="col-xs-12"><input readonly="readonly" type="text" id="dataFinal" class="date"/></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<ul class="rules">
					<li class="row">
						<div class="col-xs-2 col-xs-1 col-sm-offset-1">
							<label for="sensores">Sensor</label>
						</div>
						<div class="col-xs-5 col-sm-4 col-sm-5">
		                    <select id="sensoresFiltros" name="sensores" class="sensoresFiltros">
								<option value="" selected="" disabled="">Selecione</option>
								<?php
									$selected = "";
									foreach ($sensores as $s) {
										if(isset($sensor))
											if ($sensor[0]["sensor_id"]==$s['sensor_id']){
												$selected = "selected";
											}
										echo '<option value="'.$s['sensor_id'].'" '.$selected.'>'.$s['nome'].'</option>';
										$selected = "";
									}
								?>
			                </select>
						</div>
						<div class="col-xs-3">
			                <select name="operacaoLogica" class="operacaoLogica">
			                    <option value=">">Maior que</option>
			                    <option value="<">Menor que</option>
			                    <option value=">=">Pelo menos</option>
			                    <option value="<=">No Máximo</option>
			                    <option value="!=">Diferente de</option>
			                    <option value="=">Igual a</option>
			                    <option value="all">Todos</option>
			                </select>
						</div>
						<div class="col-xs-2">
							<input class="operacaoLogicaValue" name="valor" maxlength="6"/>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-sm-3">
				<div class="addrule">
					<i class="fa fa-plus-circle fa-lg"></i>
					<span>Adicionar regra</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-2 col-sm-offset-5">
				<div class="btsubmitrules">Submeter</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div id="resultado">
					<table id="resultado-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					</table>
				</div>
			</div><!-- /.col-xs-12 -->
		</div><!-- /.row -->
		<div class="row">
			<div class="col-xs-12">
                <div id="resultDataTable"></div>
			</div><!-- /.col-xs-12 -->
		</div><!-- /.row -->
	</div>
</section>


<!-- TEMPLATE PARA A RULE -->
<li class="row ruleTemplate" style="display: none;">
	<div class="col-xs-3 col-sm-1">
		<select name='conectorEOU' class="conectorEOU">
			<option value='OR'>Ou</option>
			<option value='AND'>E</option>
		</select>
	</div>
	<div class="col-xs-3 col-sm-1">
		<label for="sensores">Contexto</label>
	</div>
	<div class="col-xs-4 col-sm-4">
		<select name="sensores" class="sensoresFiltros">
            <option value="" selected="" disabled="">Selecione</option>
				<?php
					$selected = "";
					foreach ($sensores as $s) {
						if(isset($sensor))
							if ($sensor[0]["sensor_id"]==$s['sensor_id']){
								$selected = "selected";
							}
						echo '<option value="'.$s['sensor_id'].'" '.$selected.'>'.$s['nome'].'</option>';
						$selected = "";
					}
				?>
        </select>
	</div>
	<div class="col-xs-5 col-sm-3">
        <select name="operacaoLogica" class="operacaoLogica">
            <option value=">">Maior que</option>
            <option value="<">Menor que</option>
            <option value=">=">Pelo menos</option>
            <option value="<=">No Máximo</option>
            <option value="!=">Diferente de</option>
            <option value="=">Igual a</option>
            <option value="all">Todos</option>
        </select>
	</div>
	<div class="col-xs-5 col-sm-2">
		<input class="operacaoLogicaValue" name="valor" maxlength="6"/>
	</div>
	<div class="col-xs-2 col-sm-1 text-center">
		<div class="removerule">
			<i class="fa fa-times fa-2x"></i>
		</div><!-- /.removerule -->
	</div>
</li>