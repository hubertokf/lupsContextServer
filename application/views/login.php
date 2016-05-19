<section class="login">
	<div class="container">
		<form class="formLogin" id="formLogin" name="formLogin" action="<?php echo base_url();?>index.php/CI_login/logar" method="post">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="login-box">
						<div class="row">
							<div class="col-xs-12">
								<h2>LOGIN</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="login">Usuário</label>	
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<input type="text" name="login" class="inputs" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="password">Senha</label>	
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<input type="password" name="password" class="inputs" />
							</div>
						</div>
						<!--div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="codigo">Código de Verificação</label>	
							</div>
						</div>
						<div class="row">
							<div class="col-xs-7 col-xs-offset-1">
								<input type="text" name="codigo" maxlength="5" class="campoCodigo">
							</div>
							<div class="col-xs-3">
								<input type="text" readonly="readonly" name="codCompara" class="campoCaptcha" value="<?php echo $captcha;?>">
							</div>
						</div-->
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<div class="erro-login-msg">
									<?php echo @$msg; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="submit">
								<div class="col-md-6 col-md-offset-3">
									<input type="submit" value="Acessar" class="botao login-submit"/>
								</div>			
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="pass-recover">
									<a class="btn-recover" href="<?php echo base_url(); ?>index.php/CI_login/recoverPassword" title="Esqueci minha senha">Esqueci minha senha!</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>