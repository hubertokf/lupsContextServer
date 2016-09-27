<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$tiposensor_id 		= $linha->tiposensor_id;
			$tiposensor_nome	= $linha->nome;
			$tiposensor_desc	= $linha->descricao;
            $tiposensor_tipo    = $linha->tipo;
			$tiposensor_unidade	= $linha->unidade;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Unidades de tiposensors</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" name="tiposensor_id" value="<?php echo @$tiposensor_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="tiposensor_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="tiposensor_nome" value="<?php echo @$tiposensor_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="tiposensor_desc">Descrição:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="tiposensor_desc" value="<?php echo @$tiposensor_desc;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="tiposensor_tipo">TIpo:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="tiposensor_tipo">
                                    <option value="">Selecione</option>
                                    <option value="1">Numério</option>
                                    <option value="2">String</option>
                                    <option value="3">Booleano</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="tiposensor_unidade">Unidade:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="tiposensor_unidade" value="<?php echo @$tiposensor_unidade;?>" />
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