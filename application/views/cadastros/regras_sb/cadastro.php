<?php
	if(isset($registro)){
    // print_r($registro->result_object());
		print_r("#");
    $regra = $registro->result_array();
		$sensor_name = $sensor->result_array();

	  }

  else{
    $regra = "";
  }


?>
<!-- <script data-main="../../js/config/index_aquisition" src="../../js/node_modules/requirejs/require.js" ></script> -->
<script data-main="../../js/config/index_aquisition" src="../../js/node_modules/requirejs/require.js" ></script>
  <div class="container">
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
    <div class="col-md-4" id= "alert_sensor" ><p id= "size-text"><strong>Este sensor já possiu uma regra vinculada<strong></p></div>
  </div>
  <div class="row">
    <div class="col-md-4 col-md-offset-2" id = "select_rules">
      <select class="form-control" id = "select_rules">
        <option value selected disabled>Selecione</option> == $0
      </select>
    </div>
    <div class="col-md-4">
      <button type="button" class = "button_rule " id = "get_scheduler">Selecioanr agendamento Existente</button>
    </div>
    <!-- <div class="col-md-4" id= "alert_sensor" ><p id= "size-text"><strong>Este sensor já possiu uma regra vinculada<strong></p></div> -->
  </div>
  <div class="row">
    <div class="col-md-2 col-md-offset-3">
      <button type="button" class = "button_rule" id = "create_scheduler">Criar agendamento</button>
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
            <option value selected disabled>Selecione o sensor</option>
        </select>
     </div>
   </div>
     <div class="row">
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
                  <div class="col-md-2 col-md-offset-5">
                    <button type="button" class = "button_rule " id = "send_scheduler">submeter agendamento</button>
                  </div>

    </div>
  </div>
