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
			            <td class="col-xs-5">TITULO</td>
			            <td class="col-xs-5">IMAGEM CABEÇALHO</td>
			            <td class="check col-xs-2"></td>
			        </tr>
					<tbody>
				</thead>
		        <?php
					foreach($linhas->result_array() as $linha){
						echo "
							<tr class='dados row'>
								<td>".$linha['titulo']."</td>
								<td>".$linha['img_cabecalho']."</td>
								<td class='buttons-row'>
									<a class='botaoEditar' id='edit-$linha[configuracao_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[configuracao_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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
