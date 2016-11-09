<section class="installation">
	<div class="container">
		<form method="post" id="form-usuario" action="./step4">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-offset-3 installation-box">
					<div class="title">
						<h4>Criação de Usuário Administrador</h4>
					</div>

					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label for="admin_username">Admin username</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
	        				<input type="text" name="admin_username" value="" />
						</div>
					</div>

					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label for="admin_email">Admin email</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
	        				<input type="text" name="admin_email" value="" />
						</div>
					</div>

					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label for="admin_password">Admin password</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
	        				<input type="text" name="admin_password" value="" />
						</div>
					</div>

					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<div class="errorRequisite">
								<?php echo validation_errors(); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<input type="submit" class="botaoConfig" name="continue" value="Continuar" />
						</div>
					</div>
				</div>
			</div>	
		</form>	
	</div>
</section>