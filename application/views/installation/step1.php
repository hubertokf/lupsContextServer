<section class="installation">
	<div class="container">
		<div class="col-xs-12 col-md-6 col-md-offset-3 installation-box">
			<div class="title">
				<h4>Requisitos de sistema</h4>
			</div>

			<table class="table table-bordered" width="100%">
				<thead>
					<tr>
						<td><strong>Requisito</strong></td>
						<td><strong>Local</strong></td>
						<td><strong>Necesário</strong></td>
						<td><strong>Status</strong></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>PHP Version</td>
						<td><?php echo phpversion(); ?></td>
						<td>5.0+</td>
						<td><?php echo (phpversion() >= '5.0') ? 'Ok' : 'Not Ok'; ?></td>
					</tr>
					<tr>
						<td>PostgreSQL</td>
						<td><?php echo extension_loaded('pgsql') ? 'On' : 'Off'; ?></td>
						<td>On</td>
						<td><?php echo extension_loaded('pgsql') ? 'Ok' : 'Not Ok'; ?></td>
					</tr>
					<tr>
						<td>database.php</td>
						<td><?php echo is_writable('application/config/database.php') ? 'Writable' : 'Unwritable'; ?></td>
						<td>Writable</td>
						<td><?php echo is_writable('application/config/database.php') ? 'Ok' : 'Not Ok'; ?></td>
					</tr>
					<tr>
						<td>config.php</td>
						<td><?php echo is_writable('application/config/config.php') ? 'Writable' : 'Unwritable'; ?></td>
						<td>Writable</td>
						<td><?php echo is_writable('application/config/config.php') ? 'Ok' : 'Not Ok'; ?></td>
					</tr>
					<tr>
						<td>uploads</td>
						<td><?php echo is_writable('uploads') ? 'Writable' : 'Unwritable'; ?></td>
						<td>Writable</td>
						<td><?php echo is_writable('uploads') ? 'Ok' : 'Not Ok'; ?></td>
					</tr>
					<tr>
						<td>Mod_rewrite</td>
						<td><?php echo in_array('mod_rewrite', apache_get_modules()) ? 'Enabled' : 'Disabled'; ?></td>
						<td>Enabled</td>
						<td><?php echo in_array('mod_rewrite', apache_get_modules()) ? 'Ok' : 'Not Ok'; ?></td>
					</tr>
				</tbody>
				
			</table>

			<form action="./step1" method="post">
				<input type="hidden" name="pre_error" id="pre_error" value="<?php if(isset($pre_error)) echo $pre_error;?>" />
				<?php if(!empty($pre_error)) echo '<div class="errorRequisite">Requisitos não satisfeitos</div>'; ?>
				
				<input type="submit" class="botaoConfig" name="continue" value="Continuar" />
			</form>

		</div>
	</div>
</section>