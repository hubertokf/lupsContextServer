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
						<td class="col-xs-4">NOME</td>
			            <td class="col-xs-4">DESCRIÇÃO</td>
			            <td class="col-xs-1">UNIDADE</td>
			            <td class="col-xs-1">TIPO</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						switch ($linha['tipo']) {
						    case 1:
						        $tipoName = "Numérico";
						        break;
						    case 2:
						        $tipoName = "String";
						        break;
						    case 3:
						        $tipoName = "Booleano";
						        break;
						}
						echo "
							<tr class='dados row'>
								<td>".$linha['nome']."</td>
								<td>".$linha['descricao']."</td>
								<td>".$linha['unidade']."</td>
								<td>".$tipoName."</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[tiposensor_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[tiposensor_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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