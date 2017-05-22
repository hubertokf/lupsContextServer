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

<?php
  if(isset($registro)){
    foreach ($registro->result() as $linha){
      $regra_id                    = $linha->regra_id;
      $regra_nome                  = $linha->nome;
      $regra_tipo                  = $linha->tipo;
      $regra_status                = $linha->status;
            $regra_arquivo_py           = $linha->arquivo_py;
            // $regra_contextointeresse    = $linha->contextointeresse_id;
            // $regra_sensor               = $linha->sensor_id;
    }
  }
?>
<section class="cadastros telaCadastro">
<script data-main="../../js/config/index_context" src="../../js/node_modules/requirejs/require.js" ></script>
      <input type="hidden" id="editable" value="<?php echo $editable ?>">
      <input type="hidden" id="editable_ruler_name" value="<?php echo @$regra[0]['nome'] ?>">
      <input type="hidden" id="editable_sensor_chose" value="<?php echo @$sensor_name[0]['nome'] ?>">
			<input type="hidden" id="editable_id_rule" value="<?php echo @$regra[0]['regra_id'] ?>">
			<input type="hidden" id="editable_rule_status" value="<?php echo @$regra[0]['status'] ?>">
      <div class="container">
        <div class="row">
          <div id="type-rule">
            <div class="col-md-6 col-md-offset-3" style="margin-top: 20px;">
              <label for="type-rule-select">Tipo de regra:</label>
              <?php
                $tipo1 = $tipo3 = "";
                if (!isset($regra_tipo)){
                  $tipo1 = 'selected="selected"';
                }elseif(isset($regra_tipo) && $regra_tipo == '1'){
                  $tipo1 = 'selected="selected"';
                }elseif(isset($regra_tipo) && $regra_tipo == '3'){
                  $tipo3 = 'selected="selected"';
                }
              ?>

              <select id="type-rule-select" <?php echo (isset($regra_tipo)) ? ' disabled' : ''; ?> >
                <option value="1" <?php echo $tipo1 ?>>Regra Python</option>
                <option value="3" <?php echo $tipo3 ?>>Motor de regras</option>
              </select>
            </div>
          </div>
        </div>
        <div id="python-rule" style="display: none;">
          <form name="formCadastro" id="formCadastro" method="post" action="./gravar_python">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de regras</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
                  <input type="hidden" name="regra_id" value="<?php echo @$regra_id;?>">

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="regra_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="regra_nome" value="<?php echo @$regra_nome;?>" />
                            </div>
                        </div>

                        <input type="hidden" name="regra_tipo" value="1" />

                        <div class="especific_field" id="script_python">
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 input">
                                    <label for="regra_arquivo_py">Arquivo Python:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 input">
                                    <input type="text" name="regra_arquivo_py" value="<?php echo @$regra_arquivo_py;?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="regra_status">Status:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="regra_status">
                                    <option value="t" <?php if(@$regra_status == 't') echo"selected"; ?> >Ativado</option>
                                    <option value="f" <?php if(@$regra_status == 'f') echo"selected"; ?> >Desativado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
              <div class="col-xs-10 col-xs-offset-1">
                <div class="erro-login-msg">
                  <?php echo validation_errors(); ?>
                </div>
              </div>
            </div>
                        <div class="row">
                            <div class="submit">
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="submit" name="botao" value="Cadastrar" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>

        <div id="motor-rule">
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
                     echo "<option id= 'sensor-$linha[sensor_id]' value='$linha[nome]'>$linha[nome]</option>";
                   }?>
            </select>
           </div>
					 <div class="col-md-4">
				 			<div class="checkbox">
				 				<input type="checkbox" id = "box_status_rules" ><label id = "label_box" style="margin-top:3px">Ativar Regra</label>
				 			</div>
				 	</div>
					<div class="col-md-8">
						<div class="checkbox">
							<input type="checkbox" style = "display: none" ><label style="margin-top:3px; display: none">Ativar Regra</label>
						</div>

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

         <div class = "row" id = "div_conditions"><h3 id = "condition_label" style = "display: none">Condições</h3>
					 <div class="row" id = "sub_labels" style = "display: none">
	 					 <div class="col-md-1 col-md-offset-1">
	 					 	<h5 class = "alter_labels">Op Lógico</h5>
	 					 </div>
	 					 <div class="col-md-4">
	 					 	<h5 class = "alter_labels">Variavel de condição</h5>
	 					 </div>
	 					 <div class="col-md-3">
	 					 	<h5 class = "alter_labels">Operador Comparativo</h5>
	 					 </div>
	 					 <div class="col-md-2">
	 					 	<h5 class = "alter_labels">valor</h5>
	 					 </div>
	 				 </div></div>
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
				</div>
			<!-- </div>



      </div> -->
</section>
