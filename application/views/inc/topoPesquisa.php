<?php
    $nr_pagina = ($nr_pagina > $total) ? $total : $nr_pagina;
?>


    <input type="hidden" name="caminho" id="caminho" value="<?php echo $caminho;?>" />
    <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo?>" />

    <section class="topoPesquisa">
        <div class="container">
            <div class="row">
                <div class="col-xs-11">
                    <div class="tituloListaDados">
                        <h2><?php echo $tituloPesquisa;?> - <?php echo $total; ?> Registro(s)</h2>
                    </div>
                </div>
                <?php if($this->uri->segment(2) != 'CI_servidorcontexto' && $this->uri->segment(2) != 'CI_permissoes' ) { ?>

                <div class="col-xs-1">
                    <div class="NovoRegistro">
                        <a class="botaoNovoRegistro" href="<?php echo base_url();?>index.php/<?php echo $caminho;?>/cadastro" alt='Novo Registro' title='Novo Registro'>
                            <i class="fa fa-plus-circle fa-3x"></i>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
    
                <?php if($this->uri->segment(2) == 'CI_permissoes' ) { ?>

                        <form method="post" action="./gravar">
                            <input type="hidden" name="permissao_usuario" value="<?php echo $perm_user; ?>">
                            <div class="row" style="margin-bottom: 30px;">
                                <div class="col-xs-2">
                                    <h4 style="font-weight: bold;">Nova Permissão</h4>
                                </div>
                                <div class="col-xs-2">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="perm_tipo">Tipo de permissão:</label>                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <select name="perm_tipo" id="perm_tipo">
                                                <option value=""></option>
                                                <option value="1">Ambiente</option>
                                                <option value="2">Contexto de Interesse</option>
                                                <option value="3">Regra</option>
                                                <option value="4">Sensor</option>
                                            </select>   
                                        </div>
                                    </div>                  
                                </div>
                                <div class="col-xs-2">                  
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="perm_registro">Registro:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <select name="perm_registro" id="perm_registro"></select>                          
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <button type="submit" style="background: none; border: 0; color: #142b55;">
                                        <i class="fa fa-plus-circle fa-3x"></i>
                                    </button>
                                </div>
                                <div class="col-xs-4">
                                    <div class="erro-login-msg">
                                        <?php echo validation_errors(); ?>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                <?php } ?>

            <div class="row">
                <div class="col-xs-12">
                    <?php echo @$msg;?>
                </div>
            </div>
        </div>
    </section>
    
    <section class="paginacao registro-total paginacao-pesquisa">
        <div class="container">
            <div class="row">                
                <?php if ($total == 0) {
                    echo "<div class='col-xs-12'><h4>Nenhum registro encontrado.</h4></div>";
                }   else { ?>
                    <div class="col-xs-2">
                        Por página: 
                        <input type="text" id="perpage" style="text-align:center;" onKeyPress="return Geral.formata(this, event)" maxlength="4" value="<?php echo $nr_pagina;?>" />
                        <a href="javascript:;" class="perpage-button">
                            <i class="fa fa-refresh fa-lg"></i>
                        </a>
                    </div>
                    <div class="col-xs-9">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                <?php
                    }
                ?> 
            </div>
        </div>
    </section>