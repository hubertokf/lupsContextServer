<?php
	if(isset($registro)){
    // print_r($registro->result_object());
    $regra = $registro->result_array();
		$sensor_name = $sensor->result_array();

	  }

  else{
    $regra = "";
  }


?>
<section class="cadastros telacadastros">
<script data-main="../../js/config/index" src="../../js/node_modules/requirejs/require.js" ></script>
      <input type="hidden" id="editable" value="<?php echo $editable ?>">
      <input type="hidden" id="editable_ruler_name" value="<?php echo @$regra[0]['nome'] ?>">
      <input type="hidden" id="editable_sensor_chose" value="<?php echo @$sensor_name[0]['nome'] ?>">
			<input type="hidden" id="editable_id_rule" value="<?php echo @$regra[0]['regra_id'] ?>">
			<input type="hidden" id="editable_id_edge" value="<?php echo @$regra[0]['id_regra_borda'] ?>">

      <div class="container">
        <div id="container_rules">

        </div>
         <div class = "row" id = "button_rule">
           <div class="col-md-2 input">
              <label id = "label_name_rule">Nome da Regra</label>
           </div>
           <div class="col-md-4">
             <input type="input" class="form-control "  id = "name_rule" >
           </div>
           <div class="col-md-2 input" style="text-align : center">
             <label id = "label_name_sensor">Eventos</label>
           </div>

           <div class="col-md-4" >
             <select class="form-control ", id = "sensors">
                 <option value="" selected="" disabled="">Selecione...</option>
             <?php $result = $sensores->result_array();
                   foreach ($result as $linha) {
                     echo "<option id= 'sensor-$linha[sensor_id]'value=$linha[nome]>'Leitura '$linha[nome]</option>";
                   }?>
            </select>
           </div>
					 	<div class="col-md-4">
								<div class="checkbox">
									<input type="checkbox" value="minutes" id = "box_status_rules" ><label id = "label_box">Ativar Regra</label>
								</div>
					 	</div>
						<div class="col-md-offset-1 col-md-7">
							<div class="checkbox" >
								<input type="checkbox" id = "box_group_rules" ><label style="">Criar grupo de regra</label>
							</div>
					 </div>
					 <div id="button_condition_action">

						<div class="col-md-2 col-md-offset-3">
               <button type="button" class = "button_rule" id = "button_add">Adicionar Condição</button>
            </div>
            <div class="col-md-2  col-md-offset-2">
               <button type="button" class = "button_rule" id = "button_add_action">Adicionar Ação</button>
            </div>
					</div>


					</div>

					<div id="group_rule" style="display:none">
						<div class="cadastro-box">
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
					</div>
					</div>

         <div class = "row" id = "div_conditions"><h3 id = "condition_label" style = "display: none">Condições</h3></div>
         <div class= "row" id = "div_action">
           <h3 id = "action_label" style = "display: none">Ações</h3>
           <div class="row bin"></div>
        </div>
        <div class="row" >
          <div class="col-md-2 col-md-offset-5">
             <button type="button" class = "button_rule" id = "create_rule">Concluir e Criar Regra</button>
          </div>
        </div>
      </div>
</section>
