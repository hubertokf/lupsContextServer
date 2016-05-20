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
			            <td class="col-xs-2">NOME</td>
						<td class="col-xs-6">SENSORES</td>
						<td class="col-xs-2">REGRA</td>
			            <td class="check col-xs-2"></td>
			        </tr>
					<tbody>
				</thead>
		        <?php
					foreach($linhas as $linha){
						$sensores_id = array();
						$sensores_nome = array();

						foreach ($linha['sensores'] as $sensor) {
							array_push($sensores_nome, $sensor['sensor_nome']);
							array_push($sensores_id, $sensor['sensor_id']);
						}
						echo "
							<tr class='dados row'>
								<td>".$linha['nome']."</td>
								<td data-id=".implode(", ", $sensores_id).">".implode(", ", $sensores_nome)."</td>";
						if (isset($linha['regra_nome']))
							echo "<td>".$linha['regra_nome']."</td>";
						else
							echo "<td></td>";
						echo "<td class='buttons-row'>";

						if ($this->session->userdata('perfilusuario_id') == 2 || $linha['podeeditar'] == "t")
							echo "<a class='botaoEditar' id='edit-".$linha['contextointeresse_id']."' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
							<a class='botaoExcluir' id='del-".$linha['contextointeresse_id']."' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>";
						echo "</td>
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