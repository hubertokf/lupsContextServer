<?php
    if(isset($registro)){
        foreach ($registro->result() as $linha){
            $configuracao_id       = $linha->configuracao_id;
            $usuario_id            = $linha->usuario_id;
            $titulo                = $linha->titulo;
            $img_cabecalho         = $linha->img_cabecalho;
            $img_projeto           = $linha->img_projeto;
            $cor_predominante      = $linha->cor_predominante;
        }
    }
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" enctype="multipart/form-data" id="formCadastro" method="post" action="./gravarGeral">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Configurações Gerais</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
                        <input type="hidden" name="configuracao_id" value="1">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="titulo">Titulo:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="titulo" value="<?php echo @$titulo;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="img_cabecalho">Imagem de cabeçalho:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="file" id="fileuploader" name="img_cabecalho" size="30" value="<?php echo @$img_cabecalho;?>"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="img_projeto">Imagem de projeto:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="file" id="fileuploader" name="img_projeto" size="30" value="<?php echo @$img_projeto;?>"/>
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
