<?php
	@$ambiente_status = 't';

	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$ambiente_id         = $linha->ambiente_id;
			$ambiente_nome       = $linha->nome;
			$ambiente_desc       = $linha->descricao;
			$ambiente_status     = $linha->status;
		}
	}
?>
<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de ambientes</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" name="ambiente_id" value="<?php echo @$ambiente_id;?>">
                        
						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="ambiente_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="ambiente_nome" value="<?php echo @$ambiente_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="ambiente_desc">Descrição:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="ambiente_desc" value="<?php echo @$ambiente_desc;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="ambiente_status">Status:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                            	<select name="ambiente_status">
									<option value="t" <?php if(@$ambiente_status == 't') echo"selected"; ?> >Ativado</option>
									<option value="f" <?php if(@$ambiente_status == 'f') echo"selected"; ?> >Desativado</option>
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
