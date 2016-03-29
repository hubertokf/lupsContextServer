<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$user_id 		= $linha->id_user;
			$user_username	= $linha->username;
			$user_passwd	= $linha->passwd;
			$user_mail 		= $linha->mail_principal;
			$user_cadastro	= mdate('%m' . '/' . '%d' .  '/' . '%Y', strtotime($linha->data_cadastro));;
		}
	}
?>
<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formPergunta" id="formPergunta" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Usuários</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
                        <input type="hidden" name="user_id" value="<?=@$user_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="user_username">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="user_username" value="<?=@$user_username;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="user_passwd">Senha</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="user_passwd" value="<?=@$user_passwd;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="user_mail">E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="user_mail" value="<?=@$user_mail;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="user_cadastro">Cadastro</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="user_cadastro" value="<?=@$user_cadastro;?>" />
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
