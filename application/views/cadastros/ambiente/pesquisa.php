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
			            <td class="col-xs-5">DESCRIÇÃO</td>
			            <td class="col-xs-1">STATUS</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						if($linha['status'] == 't'){
							echo "
								<tr class='dados row'>
									<td>".$linha['nome']."</td>
									<td>".$linha['descricao']."</td>
									<td>Ativo</td>
									<td class='buttons-row'>
										<a class='botaoStatus' id='view-$linha[ambiente_id]' data-status='$linha[status]' href='javascript:;' alt='Desativar Ambiente' title='Desativar Ambiente'><i class='fa fa-pause fa-2x'></i></a>
										<a class='botaoEditar' id='edit-$linha[ambiente_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
										<a class='botaoExcluir' id='del-$linha[ambiente_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
									</td>
								</tr>
							";
						}else{
							echo "
								<tr class='dados row'>
									<td>".$linha['nome']."</td>
									<td>".$linha['descricao']."</td>
									<td>Inativo</td>
									<td class='buttons-row'>
										<a class='botaoStatus' id='view-$linha[ambiente_id]' data-status='$linha[status]' href='javascript:;' alt='Ativar Ambiente' title='Ativar Ambiente'><i class='fa fa-play fa-2x'></i></a>
										<a class='botaoEditar' id='edit-$linha[ambiente_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
										<a class='botaoExcluir' id='del-$linha[ambiente_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
									</td>
								</tr>
							";
						}
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