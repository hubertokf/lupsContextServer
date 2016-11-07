<?php
	if(isset($registro)){
    // print_r($registro->result_object());
    $rule = $registro->result_array();
		$rule_name = $array->result_array();
	  }
  else{
    $regra = "";
  }
?>
<section class="cadastros telacadastros">
<script data-main="../../js/config/index_transition" src="../../js/node_modules/requirejs/require.js" ></script>
      <input type="hidden" id="editable" value="<?php echo $editable ?>">
      <input type="hidden" id="editable_ruler_name" value="<?php echo @$regra[0]['nome'] ?>">
      <input type="hidden" id="editable_sensor_chose" value="<?php echo @$rule_name[0]['nome'] ?>">
			<input type="hidden" id="editable_id_rule" value="<?php echo @$regra[0]['regra_id'] ?>">
			<input type="hidden" id="editable_id_edge" value="<?php echo @$regra[0]['id_regra_borda'] ?>">

      <div class="container">
			<div class ="row">
			<div class="col-xs-12">
			<div class="cadastro-box">
						<div class="row">
              <div class="col-xs-offset-5 col-xs-2 input" style="text-align : center">
                <label id = "label_name_rule">Nome da Regra</label>
              </div>
						</div>
						<div class="row">
              <div class="col-xs-offset-4 col-xs-4">
                  <input type="input" class="form-control "  id = "name_rule" >
              </div>
						</div>
						<div class="row">
              <div class="col-xs-offset-5 col-xs-2 input" style="text-align : center">
                <label id = "label_name_sensor">sensor de disparo</label>
              </div>
						</div>
					<div class="row">
           <div class="col-xs-offset-4 col-xs-4 col" >
             <select class="form-control ", id = "sensors">
                 <option value="" selected="" disabled="">Selecione...</option>
                 <?php $result = $sensores->result_array();
                    foreach ($result as $sensores) {
                      echo "<option id= 'sensor-$sensores[sensor_id]'value=$sensores[nome]>$sensores[nome]</option>";
                   	}
									?>
            </select>
           </div>
				 </div>
				 <div class="row">
					 	<div class="col-xs-offset-4 col-xs-4" style = "padding-bottom: 11px; padding-top: 3px">
									<label>Ativar Regra de Transição</label><input type="checkbox" value="minutes" id = "box_status_rules" >
					 	</div>
				</div>
				<div class="row">
						<div class="col-xs-offset-4 col-xs-4" style = "padding-bottom: 11px; text-align : center">
										 <label>Adicionar Regras</label>
							 </div>
				 </div>
         <div class="row">
             <div class="col-xs-offset-3 col-xs-6">
                 <select class="sensorsOutCI form-control">
                     <?php
                     $rules_id = array();
                     if (isset($contextointeresse_sensores)){
                         foreach ($contextointeresse_sensores as $teste) {
                             array_push($rules_id, $teste['sensor_id']);
                         }
                     }
                     foreach ($rules->result_array() as $rule){
                         if (!in_array($rule['sensor_id'], $rules_id)){
                             echo '<option data-id="'.$rule['regra_id'].'" value="'.$rule['id_regra_borda'].'">'.$rule['nome'].'</option>';
                         }
                     }
                     ?>
                 </select>
             </div>
             <div class="col-xs-1">
                 <div id="insertRulesCI">
                     <i class="fa fa-plus-circle fa-3x"></i>
                 </div>
             </div>
         </div>
				 <div class="row">
					 <div class="col-xs-offset-5 col-xs-2 input" style="text-align : center; padding-top: 10px">
						 <label >Regras acionadas</label>
					 </div>
				 </div>
         <div class="row">
             <div class="col-xs-offset-2 col-xs-8">
                 <ul class="ciSensorList">
                     <?php foreach ($rules->result_array() as $rule){
          	 							if (in_array($rule['regra_id'], $rules_id)){
                             $checked = false;
                             foreach ($trigger as $trig) {
                                 if ($trig['regra_id'] == $rule['regra_id'])
                                     $checked = true;
                             }
                             if (isset($checked) && $checked == true)
                                 echo "<li class='ciSensorItem' data-id='".$rule['regra_id']."' data-text='".$rule['nome']."'><input type='hidden' name='contextointeresse_sensores[]' value='".$rule['sensor_id']."'><div class='col-xs-11'>".$rule['nome']."</div><div class='col-xs-1'><div class='removeSensorCI'><i class='fa fa-times fa-2x' style ='padding-top : 2px'></div></i></div></li>";
                             else
                                 echo "<li class='ciSensorItem' data-id='".$rule['regra_id']."' data-text='".$rule['nome']."'><input type='hidden' name='contextointeresse_sensores[]' value='".$rule['sensor_id']."'><div class='col-xs-11'>".$rule['nome']."</div><div class='col-xs-1'><div class='removeSensorCI'><i class='fa fa-times fa-2x' style ='padding-top : 2px'></div></i></div></li>";
                         }
                     }
                     ?>
                 </ul>
             </div>
         </div>
				 <div class="row">
					 <div class="col-xs-offset-1 col-xs-3 input" style="text-align : left; padding-bottom: 10px">
						 <label id = "label_name_rule">Regra de verificação de Estado</label>
					 </div>
				 </div>
				 <div class="row">
					 <div class="col-xs-1">
						 <div class="row">
 	 					 <div class="col-xs-offset-8 col-xs-1"style= "padding-top: 8px;">
 	  						<input type="checkbox" id="has_value">
 	  				</div>
						</div>
 					</div>
					 <div class="col-xs-4 status">
						 <select class="form-control " id="select_value_sensor">
							 <option value="pin" selected="" disabled="">Selecione</option>
							 <?php $result = $conditions;
							    foreach ($result as $condicoes) {
							      echo "<option data-type='".$condicoes['tipo']."' data-name='".$condicoes['nome']."'value=".$condicoes['sensor'].">".$condicoes['nome_legivel']."</option>";
							    }
							  ?>
						 </select>
					 </div>
					 <div class="col-xs-3 status">
						 <select class="form-control" id="compare_transition_status"><option value="greater_than">Maior que</option>
							 <option value="greater_than_or_equal_to">Maior ou igual</option>
							 <option value="less_than">Menor que</option>
							 <option value="less_than_or_equal_to">Menor ou igual</option>
							 <option value="equal_to">Igual</option>
						 </select>
					 </div>
					 <div class="col-xs-2 status">
						 <form class="form-inline">
							 <div class="form-group">
						 	 	<input type="text" class="form-control  inputs" id="input_status">
					 		</div>
					 	</form>
				 </div>
				 <div class="col-xs-1 status" id="mid0">
					 <a class="botaoExcluir remove" id="exc0">
						 <i class="fa fa-times fa-2x"></i>
					 </a>
				 </div>
				</div>

				<div class="row">
					<div class="col-xs-offset-1 col-xs-2 input" style="text-align : left; padding-bottom: 10px">
						<label id = "label_name_rule">Avaliação temporal</label>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-1">
						<div class="row">
						<div class="col-xs-offset-8 col-xs-1"style= "padding-top: 8px;">
						 		<input type="checkbox" id="has_time">
				 		</div>
			 			</div>
				 </div>
					<div class="col-xs-4 time">
						<select class="form-control time" id="select_type_time">
							<option value="" selected="" disabled="">Selecione o tempo</option>
							<option data-type="number" data-name="verify_time_and_trigger_rules" value="hour">Tempo da janela em horas</option>
							<option data-type="number" data-name="verify_time_and_trigger_rules" value="minute">Tempo da janela em minutos</option>
						</select>
					</div>
					<div class="col-xs-3 time">
						<select class="form-control" id="compare_transition_time"><option value="greater_than">Maior que</option>
							<option value="greater_than_or_equal_to">Maior ou igual</option>
							<option value="less_than">Menor que</option>
							<option value="less_than_or_equal_to">Menor ou igual</option>
							<option value="equal_to">Igual</option>
						</select>
					</div>
					<div class="col-xs-2 time">
						<form class="form-inline">
							<div class="form-group">
							 <input type="text" class="form-control inputs" id="input_time">
						 </div>
					 </form>
				</div>
				<div class="col-xs-1 time" id="mid0">
					<a class="botaoExcluir remove" id="exTime">
						<i class="fa fa-times fa-2x"></i>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-offset-1 col-xs-3 input" style="text-align : left; padding-bottom: 10px">
					<label >Próxima Janela</label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-4">
					<select class="form-control " id="select_value_sensor">
						<option value="" selected="" disabled="">Selecione regra</option>
						<?php $result = $transitions->result_array();
							 foreach ($result as $condicoes) {
								 echo "<option value=".$condicoes['id_regra_borda'].">".$condicoes['nome_legivel']."</option>";
							 }
						 ?>
					</select>
				</div>
				<div class="col-xs-offset-3 col-xs-2"  style="margin-top: -26px">
					<button type="button" class = "button_rule " id = "submit_rules_transition">submeter agendamento</button>
				</div>
			</div>

			 </div>
       </div>
		 </div>
		 </div>
		 <!-- <div class="container">
		 		<div class ="row">
		 			<div class="col-xs-12">
		 				<div class="cadastro-box">
							<div class="row">
								<div class="col-xs-1 col-xs-offset-11">
                    <div class="NovoRegistro">
                        <a class="botaoNovoRegistro" id="new_rule" alt="Novo Registro" title="Novo Registro">
                            <i class="fa fa-plus-circle fa-3x"></i>
                        </a>
                    </div>
                </div>
							</div>
		 				</div>
					</div>
				</div>
			</div>

			<div class="row rules" id="init" style="display : none">
				<div class="col-xs-offset-1 col-xs-4">
					<select class="form-control " id="select_value_sensor">
						<option value="" selected="" disabled="">Selecione</option>
						<?php $result = $conditions;
							 foreach ($result as $condicoes) {
								 echo "<option data-type='".$condicoes['tipo']."' data-name='".$condicoes['nome']."'value=".$condicoes['sensor'].">".$condicoes['nome_legivel']."</option>";
							 }
						 ?>
					</select>
				</div>

				<div class="col-xs-3">
					<select class="form-control" id="compare_transition_status"><option value="greater_than">Maior que</option>
						<option value="greater_than_or_equal_to">Maior ou igual</option>
						<option value="less_than">Menor que</option>
						<option value="less_than_or_equal_to">Menor ou igual</option>
						<option value="equal_to">Igual</option>
					</select>
				</div>
				<div class="col-xs-2">
					<form class="form-inline">
						<div class="form-group">
						 <input type="text" class="form-control  inputs" id="input_status">
					 </div>
				 </form>
			</div>
			<div class="col-xs-1" >
				<div class="purge">
					<a class="botaoExcluir remove">
						<i class="fa fa-times fa-2x"></i>
					</a>
				</div>
			</div>
		 </div> -->

</section>
