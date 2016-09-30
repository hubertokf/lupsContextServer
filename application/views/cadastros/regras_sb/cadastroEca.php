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
<script data-main="../../js/config/index" src="../../js/node_modules/requirejs/require.js" ></script>
      <input type="hidden" id="editable" value="<?php echo $editable ?>">
      <input type="hidden" id="editable_ruler_name" value="<?php echo @$regra[0]['nome'] ?>">
      <input type="hidden" id="editable_sensor_chose" value="<?php echo @$sensor_name[0]['nome'] ?>">
			<input type="hidden" id="editable_id_rule" value="<?php echo @$regra[0]['regra_id'] ?>">
			<input type="hidden" id="editable_id_edge" value="<?php echo @$regra[0]['id_regra_borda'] ?>">

      <div class="container">
        <div id="container_rules">

        </div>
         <div  id = "button_rule">
           <div class="col-md-2 input">
              <label id = "label_name_rule">Nome da Regra</label>
           </div>
           <div class="col-md-4">
             <input type="input" class="form-control "  id = "name_rule" >
           </div>
           <div class="col-md-2 input">
             <label id = "label_name_sensor">Lista de sensores</label>
           </div>

           <div class="col-md-4" >
             <select class="form-control ", id = "sensors">
                 <option value="" selected="" disabled="">Selecione...</option>
             <?php $result = $sensores->result_array();
                   foreach ($result as $linha) {
                     echo "<option id= 'sensor-$linha[sensor_id]'value=$linha[nome]>$linha[nome]</option>";
                   }?>
            </select>
           </div>

           <!-- <div class="col-md-4" id = "padding_size">
             oiiiiiiiiiiiiiiiiiiiiiiii
           </div> -->
           <div class="col-md-2 col-md-offset-3">
              <button type="button" class = "button_rule" id = "button_add">Adicionar Condição</button>
           </div>
           <div class="col-md-2  col-md-offset-2">
              <button type="button" class = "button_rule" id = "button_add_action">Adicionar Ação</button>
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
