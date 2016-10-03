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
			            <td class="col-xs-4">Nome</td>
			            <td class="col-xs-4">Descrição</td>
			            <td class="col-xs-1">URL</td>
			            <td class="col-xs-1">Access Token</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						echo "
							<tr class='dados row'>
								<td>".$linha['nome']."</td>
								<td>".$linha['descricao']."</td>
								<td>".$linha['url']."</td>
								<td>".$linha['access_token']."</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[servidorcontexto_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
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