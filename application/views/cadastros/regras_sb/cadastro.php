<?php
if(isset($registro)){
	// print_r($registro->result_object());
	// print_r("#");
	$regra = $registro->result_array();
	$sensor_name = $sensor->result_array();
	// print_r($sensor_name);

}

else{
	$regra = "";
}


?>
<!-- <script data-main="../../js/config/index_aquisition" src="../../js/node_modules/requirejs/require.js" ></script> -->
<script data-main="../../js/config/index_aquisition" src="../../js/node_modules/requirejs/require.js" ></script>
<input type="hidden" id="editable" value="<?php echo $editable ?>">
<input type="hidden" id="editable_ruler_name" value="<?php echo @$regra[0]['nome'] ?>">
<input type="hidden" id="editable_sensor_chose" value="<?php echo @$sensor_name[0]['sensor_id'] ?>">
<input type="hidden" id="editable_id_rule" value="<?php echo @$regra[0]['regra_id'] ?>">
<div class="container">
	<div class="row" id="regulate_1">
		<div class="col-md-2 col-md-offset-2" id= "label_name_rules"><label>Digite o nome da regra</label></div>
		<div class="col-md-8">
			<div class="col-md-8">
				<div class="form-group">
					<input type="text" class="form-control" id="rules_name" >
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-2" id= "label_sensor"><label>Escolha o Sensor</label></div>
	</div>

	<div class="row">
		<div class="col-md-4 col-md-offset-2" id = "select_sensor">
			<select class="form-control" id = "select_sensors">
				<option value selected disabled>Selecione</option> == $0
				<?php $result = $sensores->result_array();
				foreach ($result as $linha) {
					echo "<option id= 'sensor-$linha[sensor_id]'value=$linha[sensor_id]>$linha[nome]</option>";
				}?>
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-md-offset-2" id = "div_select_rules">
			<select class="form-control" id = "select_rules">
				<option value selected disabled>Selecione</option> == $0
			</select>
		</div>
		<div class="col-md-4">
			<button type="button" class = "button_rule " id = "get_scheduler">Selecionar agendamento Existente</button>
		</div>
		<!-- <div class="col-md-4" id= "alert_sensor" ><p id= "size-text"><strong>Este sensor já possiu uma regra vinculada<strong></p></div> -->
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-5">
			<button type="button" class = "button_rule" id = "create_scheduler">Construir agendamento</button>
		</div>
		<div class="col-md-2">
			<!-- <button type="button" class = "button_rule visible" id = "get_scheduler">Selecioanr agendamento Existente</button> -->
		</div>
		<div class="col-md-2">
			<!-- <button type="button" class = "button_rule visible" id = "view_scheduler">Ver agendamento</button> -->
		</div>
	</div>
</div>
<div class="container" id = "create_aquisiton">
	<div class="row">
		<div class="col-md-2 col-md-offset-5">
			<select class= "form-control" name="select_aquisiiton" id = "select_aquisiiton">
				<option value selected disabled>Selecione</option>
			</select>
		</div>
	</div>
	<div class="row" id="option_with_check_inputs" style="display:none">
		<div class ="col-md-2 col-md-offset-5">
			<div class="checkbox">
				<label id = "labelminutes"><input type="checkbox" value="minutes" id = "checkminutes" >Minutos</label>
			</div>
		</div>
		<div class ="col-md-3">
			<div class="form-group">
				<input type="text" class="form-control" id="inputminutes" >
			</div>
		</div>
		<div class ="col-md-2 col-md-offset-5">
			<div class="checkbox">
				<label id = "labelhour"><input type="checkbox" value="hours" id = "checkhour" >Horas</label>
			</div>
		</div>
		<div class ="col-md-3">
			<div class="form-group">
				<input type="text" class="form-control" id="inputhours" >
			</div>
		</div>

		<div class ="col-md-2 col-md-offset-5">
			<div class="checkbox">
				<label id = "labelday"><input type="checkbox" value="days" id = "checkday" >Dias</label>
			</div>
		</div>
		<div class ="col-md-3">
			<div class="form-group">
				<input type="text" class="form-control" id="inputdays" >
			</div>
		</div>
		<div class ="col-md-2 col-md-offset-5">
			<div class="checkbox">
				<label id = "labelmonth"><input type="checkbox" value="months" id = "checkmonth" >Mês</label>
			</div>
		</div>
		<div class ="col-md-3">
			<div class="form-group">
				<input type="text" class="form-control" id="inputmonths" >
			</div>
		</div>
	</div>
	<div class="row" id = "interval" style="display:none">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="row">
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label for="sensor_valormin">Valor Mínimo</label>
					</div>
					<div class="col-xs-5">
						<label for="sensor_valormax">Valor Máximo</label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<div class="form-group">
							<input type="number" class="form-control" id="init" >
						</div>
					</div>
					<div class="col-xs-5 ">
						<div class="form-group">
							<input type="number" class="form-control" id="finish"  >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label for="sensor_valormin">A cada</label>
					</div>

				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<select class="form-control" id = "option_interval">
							<option value selected disabled>Selecione</option>
							<option value="hours">Horas</option>
							<option value="minutes">Minutos</option>
						</select>
					</div>
					<div class="col-xs-5 input">
						<div class="form-group">
							<input type="number" class="form-control" id="value_of_trigger" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 col-md-offset-5">
		<button type="button" class = "button_rule " id = "send_scheduler">submeter agendamento</button>
	</div>
</div>
<!--AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA  -->

</div>
