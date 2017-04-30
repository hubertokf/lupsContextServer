<?php
    @$gateway_status = 't';

	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$topico_id 			= $linha->topico_id;
			$topico_nome			= $linha->nome;
		}
	}

?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Tópicos</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
                        <div class="row">
                            <div class="col-xs-1 col-xs-offset-1">
                                <label for="topico_id">ID:</label>
                            </div>
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="topico_id" readonly value="<?php echo @$topico_id;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="topico_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="topico_nome" value="<?php echo @$topico_nome;?>" />
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
