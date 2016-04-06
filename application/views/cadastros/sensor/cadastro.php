<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$sensor_id 				= $linha->sensor_id;
			$sensor_nome			= $linha->nome;
			$sensor_desc			= $linha->descricao;
			$sensor_modelo			= $linha->modelo;
			$sensor_precisao 		= $linha->precisao;
			$sensor_valormin		= $linha->valormin;
			$sensor_valormax		= $linha->valormax;
			$sensor_valormin_n      = $linha->valormin_n;
            $sensor_valormax_n      = $linha->valormax_n;
            $sensor_inicio_luz      = $linha->inicio_luz;
            $sensor_fim_luz         = $linha->fim_luz;
			$sensor_fabricante		= $linha->fabricante_id;
			$sensor_tipo 			= $linha->tiposensor_id;
			$sensor_ambiente		= $linha->ambiente_id;
            $sensor_gateway         = $linha->gateway_id;
            $sensor_servidorborda   = $linha->servidorborda_id;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
		<form name="formPergunta" id="formPergunta" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Sensores</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
		            	<!--input type="hidden" name="sensor_id" value="<?php echo @$sensor_id;?>"-->
                        <div class="row">
                            <div class="col-xs-1 col-xs-offset-1">
                                <label for="sensor_id">ID:</label>
                            </div>
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="sensor_id" readonly value="<?php echo @$sensor_id;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="sensor_nome" value="<?php echo @$sensor_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_desc">Descrição:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="sensor_desc" maxlength="300" value="<?php echo @$sensor_desc;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_modelo">Modelo:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="sensor_modelo" maxlength="50" value="<?php echo @$sensor_modelo;?>" />
                            </div>
                        </div>

                        <!--div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_precisao">Precisão:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="sensor_precisao" value="<?php echo @$sensor_precisao;?>" />
                            </div>
                        </div>-->

                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <label for="sensor_inicio_luz">Hora inicial:</label>
                            </div>
                            <div class="col-xs-5">
                                <label for="sensor_fim_luz">Hora final:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <input type="text" class="timemask" name="sensor_inicio_luz" value="<?php echo @$sensor_inicio_luz;?>" />
                            </div>
                            <div class="col-xs-5 input">
                                <input type="text" class="timemask" name="sensor_fim_luz" value="<?php echo @$sensor_fim_luz;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <label for="sensor_valormin">Valor Mínimo (Dia):</label>
                            </div>
                            <div class="col-xs-5">
                                <label for="sensor_valormax">Valor Máximo (Dia):</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <input type="text" name="sensor_valormin" value="<?php echo @$sensor_valormin;?>" />
                            </div>
                            <div class="col-xs-5 input">
                                <input type="text" name="sensor_valormax" value="<?php echo @$sensor_valormax;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <label for="sensor_valormin">Valor Mínimo (Noite):</label>
                            </div>
                            <div class="col-xs-5">
                                <label for="sensor_valormax">Valor Máximo (Noite):</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <input type="text" name="sensor_valormin_n" value="<?php echo @$sensor_valormin_n;?>" />
                            </div>
                            <div class="col-xs-5 input">
                                <input type="text" name="sensor_valormax_n" value="<?php echo @$sensor_valormax_n;?>" />
                            </div>
                        </div>

						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_fabricante">Fabricante:</label>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<select name="sensor_fabricante">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($fabricantes->result() as $fabricante){
											if ($fabricante->fabricante_id==@$sensor_fabricante){
												$selected = "selected";
											}
											echo '<option value="'.$fabricante->fabricante_id.'" '.$selected.'>'.$fabricante->nome.'</option>';
											$selected = "";
										}
									?>
								</select>
							</div>
						</div>

						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_tipo">Tipo:</label>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<select name="sensor_tipo">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($tiposensores->result() as $tipo){
											if ($tipo->tiposensor_id==@$sensor_tipo){
												$selected = "selected";
											}
											echo '<option value="'.$tipo->tiposensor_id.'" '.$selected.'>'.$tipo->nome.'</option>';
											$selected = "";
										}
									?>
								</select>
							</div>
						</div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_servidorborda">Servidor de Borda:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <select name="sensor_servidorborda" id="sensor_servidorborda">
                                    <option value="" selected="" disabled="">Selecione...</option>
                                    <?php
                                        $selected = "";
                                        foreach ($bordas->result() as $borda){
                                            if ($borda->servidorborda_id==@$sensor_servidorborda){
                                                $selected = "selected";
                                            }
                                            echo '<option value="'.$borda->servidorborda_id.'" '.$selected.'>'.$borda->nome.'</option>';
                                            $selected = "";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_gateway">Gateways:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <input type="hidden" id="sel_sensor_gateway" value="<?php echo @$sensor_gateway;?>">
                                <select name="sensor_gateway" id="sensor_gateway">
                                    <option value="" selected="" disabled="">Selecione um Servidor de Borda</option>
                                </select>
                            </div>
                        </div>

						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="sensor_ambiente">Ambiente:</label>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<select name="sensor_ambiente">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($ambientes->result() as $ambiente){
											if ($ambiente->ambiente_id==@$sensor_ambiente){
												$selected = "selected";
											}
											echo '<option value="'.$ambiente->ambiente_id.'" '.$selected.'>'.$ambiente->nome.'</option>';
											$selected = "";
										}
									?>
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
</section>

