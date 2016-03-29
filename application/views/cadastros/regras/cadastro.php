<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$regra_id                    = $linha->regra_id;
			$regra_nome                  = $linha->nome;
			$regra_tipo                  = $linha->tipo;
			$regra_status                = $linha->status;
            $regra_arquivo_py           = $linha->arquivo_py;
            $regra_contextointeresse    = $linha->contextointeresse_id;
            $regra_sensor               = $linha->sensor_id;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
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

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="regra_contextointeresse">Contexto Interesse:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <select name="regra_contextointeresse" id="regra_contextointeresse">
                                    <option value="" selected="" disabled="">Selecione...</option>
                                    <?php
                                        $selected = "";
                                        foreach ($contextointeresse as $ci){
                                            if ($ci['contextointeresse_id']==@$regra_contextointeresse){
                                                $selected = "selected";
                                            }
                                            echo '<option value="'.$ci['contextointeresse_id'].'" '.$selected.'>'.$ci['nome'].'</option>';
                                            $selected = "";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="regra_sensor">Sensor:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <input type="hidden" id="regra_sensor_id" value="<?php echo @$regra_sensor;?>">
                                <select name="regra_sensor" id="regra_sensor">
                                    <option value="" selected="" disabled="">Selecione um Contexto de Interesse</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="regra_tipo">Tipo:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <select name="regra_tipo" class="sel_regra_tipo">
                                    <option value="1" selected="" >Script Python</option>
                                </select>
                            </div>
                        </div>

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
</section>