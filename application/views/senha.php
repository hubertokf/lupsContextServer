<div class="contentInicio center">
		<form class="formLogin" name="formLogin" action="<?php echo base_url();?>index.php/CI_login/recuperar" method="post">
			<h3>RECUPERAR SENHA</h3>
		    <div class="labels">
				<label for="email">E-mail</label>
		    </div>    
		    <div class="campos">
				<input type="text" name="email" class="inputs" />
		    </div>    
		    <input type="submit" value="Recuperar" class="botao"/>
		    <div class="clear"><!-- --></div>
		    <p><a class="btn-recover" href="<?php echo base_url(); ?>index.php/CI_login/" title="Voltar ao menu inicial">Volar ao menu inicial!</a></p>
		</form>
</div>
