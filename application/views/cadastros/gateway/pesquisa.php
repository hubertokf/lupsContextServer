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
			            <td class="col-xs-2">MODELO</td>
			            <td class="col-xs-1">FABRICANTE</td>
			            <td class="col-xs-3">SERVIDOR DE BORDA</td>
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
									<td>".$linha['modelo']."</td>
									<td data-id=".$linha['fabricante_id'].">".$linha['fabricante_nome']."</td>
									<td data-id=".$linha['servidorborda_id'].">".$linha['servidorborda_nome']."</td>
									<td>Ativo</td>
									<td class='buttons-row'>
										<a class='botaoStatus' id='view-$linha[gateway_id]' data-status='$linha[status]' href='javascript:;' alt='Desativar Gateway' title='Desativar Gateway'><i class='fa fa-pause fa-2x'></i></a>
										<a class='botaoEditar' id='edit-$linha[gateway_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
										<a class='botaoExcluir' id='del-$linha[gateway_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
									</td>
								</tr>
							";	
						}else{
							echo "
								<tr class='dados row'>
									<td>".$linha['nome']."</td>
									<td>".$linha['modelo']."</td>
									<td data-id=".$linha['fabricante_id'].">".$linha['fabricante_nome']."</td>
									<td data-id=".$linha['servidorborda_id'].">".$linha['servidorborda_nome']."</td>
									<td>Inativo</td>
									<td class='buttons-row'>
										<a class='botaoStatus' id='view-$linha[gateway_id]' data-status='$linha[status]' href='javascript:;' alt='Ativar Gateway' title='Ativar Gateway'><i class='fa fa-play fa-2x'></i></a>
										<a class='botaoEditar' id='edit-$linha[gateway_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
										<a class='botaoExcluir' id='del-$linha[gateway_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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