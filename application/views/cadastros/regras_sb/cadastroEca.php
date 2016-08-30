<?php
	// if(isset($registro)){
	// 	foreach ($registro as $linha){
	// 		$contextointeresse_id 			         = $linha['contextointeresse_id'];
	// 		$contextointeresse_nome		             = $linha['nome'];
  //           $contextointeresse_sensores              = $linha['sensores'];
	// 		$contextointeresse_publico	             = $linha['publico'];
  //           $contextointeresse_regra                 = $linha['regra_id'];
	// 	}
	// }
?>
<script data-main="../../js/config/index" src="../../js/node_modules/requirejs/require.js" ></script>
      <div class="container">
        <div id="container_rules">
          
        </div>
         <div class="row" id = "button_rule">
           <div class="col-md-2 input">
              <label id = "label_name_rule">Nome da Regra</label>
           </div>
           <div class="col-md-4">
             <input type="input"  id = "name_rule" >
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
