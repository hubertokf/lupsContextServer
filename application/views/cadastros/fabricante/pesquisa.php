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
			            <td class="col-xs-3">NOME</td>
			            <td class="col-xs-2">ENDEREÇO</td>
						<td class="col-xs-1">TELEFONE</td>
			            <td class="col-xs-2">URL</td>
			            <td class="col-xs-1">CIDADE</td>
			            <td class="col-xs-1">ESTADO</td>
			            <td class="col-xs-1">PAÍS</td>
			            <td class="check col-xs-2"></td>
			        </tr>
					<tbody>
				</thead>
		        <?php
					foreach($linhas->result_array() as $linha){
						echo "
							<tr class='dados row'>
								<td>".$linha['nome']."</td>
								<td>".$linha['endereco']."</td>
								<td>".$linha['telefone']."</td>
								<td>".$linha['url']."</td>
								<td>".$linha['cidade']."</td>
								<td>".$linha['estado']."</td>
								<td>".$linha['pais']."</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[fabricante_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[fabricante_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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