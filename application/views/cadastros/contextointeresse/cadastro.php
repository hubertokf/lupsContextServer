<?php
	if(isset($registro)){
		foreach ($registro as $linha){
			$contextointeresse_id 			         = $linha['contextointeresse_id'];
			$contextointeresse_nome		             = $linha['nome'];
            $contextointeresse_sensores              = $linha['sensores'];
			$contextointeresse_publico	             = $linha['publico'];
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
                                <label for="contextointeresse_sensores[]">Sensores:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-1 input">
                                <select class="sensorsOutCI" size="10" multiple>
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
                            <div class="col-xs-2 input">
                                <input type="button" class="addSensortoCI" value="&gt;&gt;" />
                                <input type="button" class="removeSensortoCI" value="&lt;&lt;" />
                            </div>
                            <div class="col-xs-4 input">
                                <select class="sensorsInCI" name="contextointeresse_sensores[]" size="10" multiple>
                                    <?php foreach ($sensores->result_array() as $sensor){
                                        if (in_array($sensor['sensor_id'], $sensores_id)){
                                            echo '<option value="'.$sensor['sensor_id'].'" selected>'.$sensor['nome'].'</option>';    
                                        }
                                    }
                                    ?>
                                </select>
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