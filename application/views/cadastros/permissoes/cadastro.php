<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$permissao_id            	  => $linha->permissao_id,
			$permissao_usuario            => $linha->usuario_id,
            $permissao_contextointeresse  => $linha->contextointeresse_id,
            $permissao_sensor             => $linha->sensor_id,
            $permissao_ambiente 		  => $linha->ambiente_id,
            $permissao_regra 	          => $linha->regra_id
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Permissões</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
						<input type="hidden" name="permissao_id" value="<?php echo @$permissao_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="permissao_usuario">Usuário</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="permissao_usuario">
									<option value="">Selecione</option>
									<?php
										$selected = "";
										foreach ($usuarios->result() as $usuario){
											if ($usuario->usuario_id==@$permissao_usuario){
												$selected = "selected";
											}
											echo '<option value="'.$usuario->usuario_id.'" '.$selected.'>'.$usuario->nome.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="permissao_contextointeresse">Contexto de Interesse</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="permissao_contextointeresse">
									<option value="">Selecione</option>
									<?php
										$selected = "";
										foreach ($cis->result() as $ci){
											if ($ci->contextointeresse_id==@$permissao_contextointeresse){
												$selected = "selected";
											}
											echo '<option value="'.$ci->contextointeresse_id.'" '.$selected.'>'.$ci->nome.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="permissao_sensor">Sensor</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="permissao_sensor">
									<option value="">Selecione</option>
									<?php
										$selected = "";
										foreach ($sensores->result() as $sensor){
											if ($sensor->sensor_id==@$permissao_sensor){
												$selected = "selected";
											}
											echo '<option value="'.$sensor->sensor_id.'" '.$selected.'>'.$sensor->nome.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="permissao_ambiente">Ambiente</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="permissao_ambiente">
									<option value="">Selecione</option>
									<?php
										$selected = "";
										foreach ($ambientees->result() as $ambiente){
											if ($ambiente->ambiente_id==@$permissao_ambiente){
												$selected = "selected";
											}
											echo '<option value="'.$ambiente->ambiente_id.'" '.$selected.'>'.$ambiente->nome.'</option>';
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