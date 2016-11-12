<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$servidorcontexto_id 		= $linha->servidorcontexto_id;
			$servidorcontexto_nome		= $linha->nome;
			$servidorcontexto_desc		= $linha->descricao;
			$servidorcontexto_url	= $linha->url;
			$servidorcontexto_access_token	= $linha->access_token;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Contextos</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" name="servidorcontexto_id" value="<?php echo @$servidorcontexto_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="servidorcontexto_nome">Nome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorcontexto_nome" value="<?php echo @$servidorcontexto_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="servidorcontexto_desc">Descrição</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorcontexto_desc" value="<?php echo @$servidorcontexto_desc;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="servidorcontexto_url">URL</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="servidorcontexto_url" value="<?php echo @$servidorcontexto_url;?>" />
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="col-xs-10 col-xs-offset-1  input">
                                <label for="servidorcontexto_access_token">Access Token</label>
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="col-xs-10 col-xs-offset-1  input">
                                <input type="text" name="servidorcontexto_access_token" value="<?php echo @$servidorcontexto_access_token;?>" />
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