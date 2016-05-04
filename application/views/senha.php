<section class="login">
	<div class="container">
		<form class="formLogin" name="formLogin" action="<?php echo base_url();?>index.php/CI_login/recuperar" method="post">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="login-box">
						<div class="row">
							<div class="col-xs-12">
								<h2>RECUPERAR SENHA</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label for="email">E-mail</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<input type="text" name="email" class="inputs" />
							</div>
						</div>
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
									<input type="submit" value="Recuperar" class="botao"/>
								</div>			
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="pass-recover">
									<a class="btn-recover" href="<?php echo base_url(); ?>index.php/CI_login/" title="Voltar ao menu inicial">Volar ao menu inicial</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>