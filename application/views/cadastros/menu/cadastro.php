<?php
    $menu_ordem = 0;
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$menu_id 		    = $linha->menu_id;
			$menu_nome		    = $linha->nome;
			$menu_parente	    = $linha->parente;
			$menu_caminho	    = $linha->caminho;
			$menu_ordem		    = $linha->ordem;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
		<form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Menus</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
		            	<input type="hidden" name="menu_id" value="<?php echo @$menu_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="menu_nome">Nome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="menu_nome" value="<?php echo @$menu_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="menu_parente">Menu Pai</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <select name="menu_parente">
									<option value="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($parentes->result() as $linha){
											if ($linha->menu_id==@$menu_parente){
												$selected = "selected";
											}
											echo '<option value="'.$linha->menu_id.'" '.$selected.'>'.$linha->nome.'</option>';
										    $selected = "";
                                        }
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="menu_caminho">Caminho</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                            	<input type="text" name="menu_caminho" value="<?php echo @$menu_caminho;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="menu_ordem">Posição</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                            	<input type="text" name="menu_ordem" value="<?php echo @$menu_ordem;?>" />
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