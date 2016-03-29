<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$perfilusuario_id 	= $linha->perfilusuario_id;
			$perfilusuario_desc	= $linha->descricao;
			$perfilusuario_nome	= $linha->nome;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Perfis</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="cadastro-box">
						<input type="hidden" name="perfilusuario_id" value="<?php echo @$perfilusuario_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="perfilusuario_nome">Nome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="perfilusuario_nome" value="<?php echo @$perfilusuario_nome;?>" />
                            </div>
                        </div>
						
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="perfilusuario_desc">Descrição</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="perfilusuario_desc" value="<?php echo @$perfilusuario_desc;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label>Permissões</label>
                            </div>
                        </div>
                        <div class="row container-menus-perfis">

	                        <?php
								$checked = "";
								$contador = 0;
								foreach ($menus->result() as $linha){
									$numRowsTotais = $this->M_menu->contarMenus(@$perfilusuario_id,$linha->menu_id);
									if ($numRowsTotais > 0) {
										$checked = "checked";
									}

									if ($contador == 0) {
										echo '<div class="col-xs-5 col-xs-offset-1">';
									}else{
										echo '<div class="col-xs-5">';
									}
									
									echo '
										<div class="item-menu-perfil">
											<div class="titulo-menu">
												<input class="checkbox-pai" type="checkbox" name="perfilusuario_menu[]" '.$checked.' value="'.$linha->menu_id.'"><div class="nome">'.$linha->nome.'</div>
											</div>';
									
									$submenus = $this->M_menu->buscarSubmenus($linha->menu_id);
									echo '<ul class="lista-menus">';
										$submenuChecked = "";
										foreach ($submenus->result() as $linhaSubmenu) {
											$numRowsTotaisSubmenu = $this->M_menu->contarMenus(@$perfilusuario_id,$linhaSubmenu->menu_id);
											if ($numRowsTotaisSubmenu > 0) {
												$submenuChecked = "checked";
											}
											echo '<li class="row"><input type="checkbox" name="perfilusuario_menu[]" '.$submenuChecked.' value="'.$linhaSubmenu->menu_id.'">'.$linhaSubmenu->nome.'</li>';
										}
									echo '</ul>';										
									echo '</div></div>';		
									$checked = "";
									$contador ++;


									if ($contador == 2) {
										echo "</div><div class='row container-menus-perfis'>";
										$contador = 0;
									}
								}
							?>
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