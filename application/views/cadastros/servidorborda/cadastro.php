<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$servidorborda_id 			= $linha->servidorborda_id;
			$servidorborda_nome			= $linha->nome;
			$servidorborda_desc			= $linha->descricao;
            $servidorborda_url          = $linha->url;
            $servidorborda_access_token = $linha->access_token;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Servidores de Borda</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
                        <div class="row">
                            <div class="col-xs-1 col-xs-offset-1">
                                <label for="servidorborda_id">ID:</label>
                            </div>
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorborda_id" readonly value="<?php echo @$servidorborda_id;?>" />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="servidorborda_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorborda_nome" value="<?php echo @$servidorborda_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="servidorborda_desc">Descrição:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorborda_desc" value="<?php echo @$servidorborda_desc;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="servidorborda_url">URL:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorborda_url" value="<?php echo @$servidorborda_url;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="servidorborda_access_token">Token de Acesso:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorborda_access_token" value="<?php echo @$servidorborda_access_token;?>" />
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