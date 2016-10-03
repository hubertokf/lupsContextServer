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
			            <td class="col-xs-1">ID</td>
			            <td class="col-xs-2">NOME</td>
			            <td class="col-xs-1">DESCRIÇÃO</td>
			            <td class="col-xs-2">URL</td>
			            <td class="col-xs-3">ACCESS TOKEN</td>
			            <td class="col-xs-1">STATUS</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						echo "
							<tr class='dados row'>
								<td style='text-align: center'>".$linha['servidorborda_id']."</td>
								<td>".$linha['nome']."</td>
								<td>".$linha['descricao']."</td>
								<td class='borda_url'>".$linha['url']."</td>
								<td>".$linha['access_token']."</td>
								<td class='borda_status' style='text-align:center;' title='Offline'><i class='fa fa-circle' aria-hidden='true' style='color:red;'></i></td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[servidorborda_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[servidorborda_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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