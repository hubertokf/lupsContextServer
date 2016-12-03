<?php
	if ($total > 0) {
?>

<section class="tabelas">
	<div class="container">
		<form class="formLista" method="post" name="lista" action="">
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
			            <td class="col-xs-4">NOME DA REGRA</td>
									<td class="col-xs-4">SERVIDOR DE BORDA</td>
			            <td class="col-xs-3">MODIFICAÇÃO E EXCLUSÃO</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						// print_r($linha);
						echo "
							<tr class='dados row'>
								 <td>".$linha['nome']."</td>
								 <td>".$linha['borda_nome']."</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[regra_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[regra_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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
