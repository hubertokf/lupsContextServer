<?php
	if ($total > 0) {
?>
<section class="tabelas">
	<div class="container">
		<form class="formLista" method="post" name="lista" action="">
			<input class="item-selected" type="hidden" name="item" id="item" value="">
			<table class="tabela-dados" cellpadding="3" cellspacing="0">
				<thead>
					<tr class="titulos row">
			            <td class="col-xs-3">USERNAME</td>
			            <td class="col-xs-2">E-MAIL</td>
						<td class="col-xs-3">DATA DE CADASTRO</td>
			            <td class="col-xs-2">ATIVO</td>
			            <td class="check col-xs-2"></td>
			        </tr>					
				</thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						echo "
							<tr class='dados row'>
								<td>$linha[username]</td>
								<td>$linha[mail_principal]</td>
								<td>".mdate('%m' . '/' . '%d' .  '/' . '%Y', strtotime($linha['data_cadastro']))."</td>
								<td>$linha[flag_inativo]</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[id_user]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[id_user]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
								</td>
							</tr>
						";	
					}
		        ?>	
				</tbody>
			</table>
		</form>
	</div>
</section>

<?php
	}
?>