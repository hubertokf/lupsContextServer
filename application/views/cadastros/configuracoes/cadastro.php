<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" enctype="multipart/form-data" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Configurações</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?php echo @$msg;?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
                        <?php
                        
                            function archange($array) {
                                $new = array();
                                foreach($array as $linha){
                                    $new = array_merge($new, array($linha['name']=>$linha['value']));
                                }
                                return $new;
                            }
                            $newData = archange($linhas->result_array());
                        ?>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="titulo">Titulo da Aplicação:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="titulo" value="<?php echo $newData['titulo'];?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="titulo_projeto">Titulo do Projeto:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="titulo_projeto" value="<?php echo $newData['titulo_projeto'];?>" />
                            </div>
                        </div>
              
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="cor_predominante">Cor predominante da aplicação:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="cor_predominante" value="<?php echo $newData['cor_predominante'];?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="email_from">Email remetente:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="email_from" value="<?php echo $newData['email_from'];?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="email_host">Host servidor e-mail:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="email_host" value="<?php echo $newData['email_host'];?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="email_port">Porta servidor e-mail:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="email_port" value="<?php echo $newData['email_port'];?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="email_user">Usuario servidor e-mail:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="email_user" value="<?php echo $newData['email_user'];?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="email_pass">Senha servidor e-mail:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="email_pass" value="<?php echo $newData['email_pass'];?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="img_cabecalho">Imagem de cabeçalho:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="file" id="fileuploader" name="img_cabecalho" size="30" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="img_projeto">Imagem de projeto:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="file" id="fileuploader" name="img_projeto" size="30" />
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
