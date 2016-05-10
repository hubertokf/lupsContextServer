<?php
	if ($total > 0) {
?>

<section class="tabelas">
	<div class="container">
		<form class="formLista" method="post" name="lista" action="./CI_sensor">
			<input class="item-selected" type="hidden" name="item" id="item" value="">
			<div class="row">
				<div class="col-xs-2">
					<label for="pesquisa_filter">Filtro por Servidor de Borda:</label>
                                </div>

				<div class="col-xs-5">
					<select name="pesquisa_filter">
						<option value="" selected="" value="">Todos</option>
						<?php
						$selected = "";
						foreach($sb->result_array() as $linha){
							if (isset($_POST["pesquisa_filter"]) && $linha['servidorborda_id']==$_POST["pesquisa_filter"]){
								$selected = "selected";
							}
							echo '<option value="'.$linha['servidorborda_id'].'" '.$selected.'>'.$linha['nome'].'</option>';
							$selected = "";
						}
						?>
					</select>
				</div>
				<div class="col-xs-1">
					<input type="submit" name="botao" value="Filtrar" style="height: 20px; font-weight:normal; ">
				</div>
			</div>
			<table class="tabela-dados" cellpadding="3" cellspacing="0">
				<thead>
					<tr class="titulos row">
			            <td class="col-xs-1">ID</td>
						<td class="col-xs-1">NOME</td>
			            <td class="col-xs-1">DESCRIÇÃO</td>
			            <td class="col-xs-1">MODELO</td>
					    <td class="col-xs-1">HORA LIMITE</td>
	 				    <td class="col-xs-1">LIMITES DIURNOS</td>
					    <td class="col-xs-1">LIMITES NOTURNOS</td>
					    <td class="col-xs-1">AMBIENTE</td>
			            <td class="col-xs-1">GATEWAY</td>
			            <td class="col-xs-1">SERVIDOR DE BORDA</td>
			            <td class="check col-xs-2"></td>
			        </tr>
				</thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						if($linha['status'] == 't'){

							echo "
								<tr class='dados row'>
									<td style='text-align: center'>".$linha['sensor_id']."</td>
									<td>".$linha['sensor_nome']."</td>
									<td>".$linha['sensor_descricao']."</td>
									<td>".$linha['sensor_modelo']."</td>
									<td align='center'>".$linha['inicio_luz']."/".$linha['fim_luz']."</td>
									<td align='center'>".$linha['valormin']."/".$linha['valormax']."</td>
									<td align='center'>".$linha['valormin_n']."/".$linha['valormax_n']."</td>
									<!--td>".$linha['precisao']."</td>
                                    <td data-id=".$linha['fabricante_id'].">".$linha['fabricante_nome']."</td>
                                    <td data-id=".$linha['tiposensor_id'].">".$linha['tiposensor_nome']."</td-->
									<td data-id=".$linha['ambiente_id'].">".$linha['ambiente_nome']."</td>
									<td data-id=".$linha['gateway_id'].">".$linha['gateway_nome']."</td>
									<td data-id=".$linha['servidorborda_id'].">".$linha['servidorborda_nome']."</td>
									<td class='buttons-row'>
										<a class='botaoStatus' id='view-$linha[sensor_id]' data-status='$linha[status]' href='javascript:;' alt='Desativar Sensor' title='Desativar Sensor'><i class='fa fa-pause fa-2x'></i></a>
										<a class='botaoEditar' id='edit-$linha[sensor_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
										<a class='botaoExcluir' id='del-$linha[sensor_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
									</td>
								</tr>
							";	
						}else{
							echo "
								<tr class='dados row'>
									<td>".$linha['sensor_nome']."</td>
									<td>".$linha['sensor_descricao']."</td>
									<td>".$linha['sensor_modelo']."</td>
									<td align='center'>".$linha['inicio_luz']."/".$linha['fim_luz']."</td>
									<td align='center'>".$linha['valormin']."/".$linha['valormax']."</td>
									<td align='center'>".$linha['valormin_n']."/".$linha['valormax_n']."</td>
									<!--td>".$linha['precisao']."</td>
                                    <td data-id=".$linha['fabricante_id'].">".$linha['fabricante_nome']."</td>
                                    <td data-id=".$linha['tiposensor_id'].">".$linha['tiposensor_nome']."</td-->
									<td data-id=".$linha['ambiente_id'].">".$linha['ambiente_nome']."</td>
									<td data-id=".$linha['gateway_id'].">".$linha['gateway_nome']."</td>
									<td data-id=".$linha['servidorborda_id'].">".$linha['servidorborda_nome']."</td>
									<td class='buttons-row'>
										<a class='botaoStatus' id='view-$linha[sensor_id]' data-status='$linha[status]' href='javascript:;' alt='Ativar Sensor' title='Ativar Sensor'><i class='fa fa-play fa-2x'></i></a>
										<a class='botaoEditar' id='edit-$linha[sensor_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
										<a class='botaoExcluir' id='del-$linha[sensor_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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
