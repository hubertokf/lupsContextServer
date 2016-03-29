<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$usuario_id 				= $linha->usuario_id;
			$usuario_perfil				= $linha->perfilusuario_id;
			$usuario_nome				= $linha->nome;
			$usuario_username			= $linha->username;
			$usuario_password			= $linha->password;
			$usuario_email 				= $linha->email;
			$usuario_telefone			= $linha->telefone;
			$usuario_celular			= $linha->celular;
			$usuario_cadastro			= $linha->cadastro;
		}
	}
?>



<section class="cadastros telaCadastro">
	<div class="container">
		<form method="post" id="form-usuario" action="./gravar">
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
            			<input type="hidden" name="usuario_id" value="<?php echo @$usuario_id;?>">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="usuario_perfil">Perfil</label>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<select name="usuario_perfil">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($perfis->result() as $linha){
											if ($linha->perfilusuario_id==@$usuario_perfil){
												$selected = "selected";
											}
											echo '<option value="'.$linha->perfilusuario_id.'" '.$selected.'>'.$linha->nome.'</option>';
											$selected = "";
										}
									?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="usuario_nome">Nome</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
	            				<input type="text" name="usuario_nome" value="<?php echo @$usuario_nome;?>" />
							</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="usuario_username">Username</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="col-xs-10 col-xs-offset-1">
		            			<input type="text" name="usuario_username" value="<?php echo @$usuario_username;?>" />
		            		</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
		                		<label for="usuario_password">Senha</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="col-xs-10 col-xs-offset-1">
		            			<input type="password" name="usuario_password" value="<?php echo @$usuario_password;?>" />
		            		</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
		                		<label for="usuario_email">E-mail</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="col-xs-10 col-xs-offset-1">
		            			<input type="text" name="usuario_email" value="<?php echo @$usuario_email;?>" />
		            		</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
		                		<label for="notificationldas">Notificação no LDAS</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="notifcheck col-xs-10 col-xs-offset-1">
		            			<div class="row">
		            				<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">Sinal Luminoso</label></div>
		            				<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">Sinal Sonoro</label></div>
	            				</div>
	            				<div class="row">
			            			<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">SMS</label></div>
			            			<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">E-mail</label></div>
		            			</div>
	            				<div class="row">
		            				<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">Aplicação Móvel</label></div>
		            			</div>
		            		</div>
						</div>

						<div class="row">
							<div class="notifcheckcol-xs-10 col-xs-offset-1">
		                		<label for="notification">Notificação fora do LDAS</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="notifcheck col-xs-10 col-xs-offset-1">
		            			<div class="row">
		            				<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">Sinal Luminoso</label></div>
		            				<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">Sinal Sonoro</label></div>
	            				</div>
	            				<div class="row">
			            			<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">SMS</label></div>
			            			<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">E-mail</label></div>
		            			</div>
	            				<div class="row">
		            				<div class="col-xs-6"><label><input class="checkbox" type="checkbox" name="notification[]" value="">Aplicação Móvel</label></div>
		            			</div>
		            		</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
		                		<label for="usuario_telefone">Telefone</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="col-xs-10 col-xs-offset-1">
		            			<input type="text" class="campo-obrigatorio" name="usuario_telefone" value="<?php echo @$usuario_telefone;?>" />
		            		</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
		                		<label for="usuario_celular">Celular</label>
							</div>
						</div>
		            	<div class="row">
		            		<div class="col-xs-10 col-xs-offset-1">
		            			<input type="text" class="campo-obrigatorio" name="usuario_celular" value="<?php echo @$usuario_celular;?>" />
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
									<input type="submit" name="botao" class="botao-submit-usuario" value="Cadastrar" />
								</div>			
							</div>
						</div>
            		</div>
            	</div>
            </div>
        </form>
	</div>
</section>
