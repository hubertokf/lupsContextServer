
<?php
	if ($total > 0) {
?>

<section class="tabelas">
	<div class="container">
		

		<form class="formLista" method="post" name="lista" action="">
			<input class="item-selected" type="hidden" name="item" id="item" value="">
			<input id="listPerm" type="hidden" value='<?php echo json_encode($linhas->result_array()); ?>'></input>
			<input class="permissao_usuario" type="hidden" name="permissao_usuario" id="permissao_usuario" value="<?php echo $perm_user; ?>">
			<table class="tabela-dados" cellpadding="3" cellspacing="0">
				<thead>
					<tr class="titulos row">
			            <td class="col-xs-5">REGISTRO</td>
			            <td class="col-xs-4">TIPO</td>
			            <td class="col-xs-1">PODE EDITAR</td>
			            <td class="col-xs-1">RECEBE EMAIL</td>
			            <td class="check col-xs-1"></td>
			        </tr>
			    </thead>
				<tbody> 
		        <?php
					foreach($linhas->result_array() as $linha){
						$linha = array_filter($linha);
						$row = "
							<tr class='dados row'>";
						if (isset($linha['contextointeresse_nome'])){
							$row .= "<td>".$linha['contextointeresse_nome']."</td>";
							$row .= "<td>Contexto de Interesse</td>";
						}
						if (isset($linha['sensor_nome'])){
							$row .= "<td>".$linha['sensor_nome']."</td>";
							$row .= "<td>Sensor</td>";
						}
						if (isset($linha['ambiente_nome'])){
							$row .= "<td>".$linha['ambiente_nome']."</td>";
							$row .= "<td>Ambiente</td>";
						}
						if (isset($linha['regra_nome'])){
							$row .= "<td>".$linha['regra_nome']."</td>";
							$row .= "<td>Regra</td>";
						}
						if ($linha['podeeditar'] == 't')
							$row .= "<td>SIM</td>";
						else
							$row .= "<td>NÃO</td>";
						if ($linha['recebeemail'] == 't')
							$row .= "<td>SIM</td>";
						else
							$row .= "<td>NÃO</td>";
						$row .= "<td class='buttons-row'>
									<!--a class='botaoEditar' id='edit-$linha[permissao_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a-->
									<a class='botaoExcluir' id='del-$linha[permissao_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
								</td>
							</tr>
						";
						echo $row;
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