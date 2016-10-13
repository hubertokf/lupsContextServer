<?php
	if(isset($registro)){
		foreach ($registro as $linha){
			$contextointeresse_id 			         = $linha['contextointeresse_id'];
			$contextointeresse_nome		             = $linha['nome'];
            $contextointeresse_sensores              = $linha['sensores'];
			$contextointeresse_publico	             = $linha['publico'];
            $contextointeresse_regra                 = $linha['regra_id'];
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Contexto de Interesse</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="cadastro-box">
		            	<input type="hidden" name="contextointeresse_id" value="<?php echo @$contextointeresse_id;?>">

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="contextointeresse_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="contextointeresse_nome" value="<?php echo @$contextointeresse_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="contextointeresse_regra">Regra:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9 col-xs-offset-1">
                                <select name="contextointeresse_regra">
                                    <option value="" selected="" disabled="">Selecione...</option>
                                    <?php
                                        $selected = "";
                                        foreach ($regras->result() as $regra){
                                            if ($regra->regra_id==@$contextointeresse_regra){
                                                $selected = "selected";
                                            }
                                            echo '<option value="'.$regra->regra_id.'" '.$selected.'>'.$regra->nome.'</option>';
                                            $selected = "";
                                        }
                                    ?>
                                </select>
                            </div>
														<div class="col-xs-1">
																<div id="addRule">
																		<i class="fa fa-plus-circle fa-3x"></i>
																</div>
														</div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label>Inclusão de sensores</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-9">
                                <select class="sensorsOutCI">
                                    <?php
                                    $sensores_id = array();
                                    if (isset($contextointeresse_sensores)){
                                        foreach ($contextointeresse_sensores as $teste) {
                                            array_push($sensores_id, $teste['sensor_id']);
                                        }
                                    }

                                    foreach ($sensores->result_array() as $sensor){
                                        if (!in_array($sensor['sensor_id'], $sensores_id)){
                                            echo '<option value="'.$sensor['sensor_id'].'">'.$sensor['nome'].'</option>';
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <div id="insertSensorCI">
                                    <i class="fa fa-plus-circle fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10">
                                <label>Sensores</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-2 col-xs-8">

                                <ul class="ciSensorList">
                                    <?php foreach ($sensores->result_array() as $sensor){
                                        if (in_array($sensor['sensor_id'], $sensores_id)){
                                            $checked = false;
                                            foreach ($trigger as $trig) {
                                                if ($trig['sensor_id'] == $sensor['sensor_id'])
                                                    $checked = true;
                                            }

                                            if (isset($checked) && $checked == true)
                                                echo "<li class='ciSensorItem' data-id='".$sensor['sensor_id']."' data-text='".$sensor['nome']."'><input type='hidden' name='contextointeresse_sensores[]' value='".$sensor['sensor_id']."'><div class='col-xs-7'>".$sensor['nome']."</div><div class='col-xs-4'><input type='checkbox' checked name='contextointeresse_trigger[]' value='".$sensor['sensor_id']."'>Dispara regra</div><div class='col-xs-1'><div class='removeSensorCI'><i class='fa fa-times fa-2x'></div></i></div></li>";
                                            else
                                                echo "<li class='ciSensorItem' data-id='".$sensor['sensor_id']."' data-text='".$sensor['nome']."'><input type='hidden' name='contextointeresse_sensores[]' value='".$sensor['sensor_id']."'><div class='col-xs-7'>".$sensor['nome']."</div><div class='col-xs-4'><input type='checkbox' name='contextointeresse_trigger[]' value='".$sensor['sensor_id']."'>Dispara regra</div><div class='col-xs-1'><div class='removeSensorCI'><i class='fa fa-times fa-2x'></div></i></div></li>";

                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-3 col-xs-offset-1">
                                <label for="contextointeresse_publico">Visível ao público:</label>
                                <?php
                                if(isset($contextointeresse_publico)) {
                                    if ($contextointeresse_publico == "f"){
                                        echo '<input type="checkbox" name="contextointeresse_publico" />';
                                    }else{
                                        echo '<input type="checkbox" name="contextointeresse_publico" checked/>';
                                    }
                                }else{
                                    echo '<input type="checkbox" name="contextointeresse_publico" checked/>';
                                }
                                ?>
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
</section>
