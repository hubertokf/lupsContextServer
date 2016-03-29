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
			            <td class="col-xs-5">SENSOR</td>
			            <td class="col-xs-2">DATA COLETA</td>
						<td class="col-xs-2">DATA PUBLICAÇÃO</td>
			            <td class="col-xs-1">VALOR COLETADO</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						echo "
							<tr class='dados row'>
								<td>".$linha['sensor_nome']."</td>
								<td>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha['datacoleta']))."</td>
								<td>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha['datapublicacao']))."</td>
								<td>".$linha['valorcoletado']." ".$linha['tiposensor_unidade']."</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[publicacao_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[publicacao_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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