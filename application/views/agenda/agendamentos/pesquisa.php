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
			            <td class="col-xs-2">USUÁRIO</td>
			            <td class="col-xs-2">AMBIENTE</td>
			            <td class="col-xs-2">DESCRIÇÃO</td>
			            <td class="col-xs-2">PERÍODO INICIAL</td>
			            <td class="col-xs-2">PERÍODO FINAL</td>
			            <td class="check col-xs-2"></td>
			        </tr>
				</thead>
				<tbody>
		        <?php
		        	$sensores = array();
		        	$sensores['id'] = array();
		        	$sensores['nome'] = array();

					foreach($linhas as $linha){
						foreach ($linha['sensores'] as $sensor) {
							array_push($sensores['id'], $sensor['sensor_id']);
							array_push($sensores['nome'], $sensor['nome']);
						}
						echo "
							<tr class='dados row'>
								<td>".$linha['nome_usuario']."</td>
								<td class='ambiente' data-sensornome='".implode(',',$sensores['nome'])."' data-sensorid='".implode(',',$sensores['id'])."' data-id='".$linha['ambiente_id']."'>$linha[nome_ambiente]</td>
								<td>".$linha['descricao']."</td>
								<td class='data_inicio' data-data='".$linha['datetimeinicial']."'>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha['datetimeinicial']))."</td>
								<td class='data_fim' data-data='".$linha['datetimefinal']."'>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha['datetimefinal']))."</td>
								<td class='buttons-row'>
									<a class='botaoVisualizar' id='view-$linha[agendamento_id]' data-toggle='modal' data-target='#modalView' href='#' alt='Visualizar Registro' title='Visualizar Registro'><i class='fa fa-line-chart fa-2x'></i></a>
									<a class='botaoEditar' id='edit-$linha[agendamento_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[agendamento_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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

<div id="modalView" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Visualização de Período</h4>
			</div>
			<div class="modal-body">
				<div id="chart"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>

	</div>
</div>

<?php
	}
?>