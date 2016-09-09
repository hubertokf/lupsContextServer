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
			            <td class="col-xs-5">NOME DA REGRA</td>
			            <td class="col-xs-5">NOME</td>
			            <td class="check col-xs-2"></td>
			        </tr>
			    </thead>
				<tbody>
		        <?php
					foreach($linhas->result_array() as $linha){
						// print_r(edit-$linha["perfilusuario_id"]);
						echo "
							<tr class='dados row'>
								 <td>".$linha['nome']."</td>
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
