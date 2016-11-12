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
			            <td class="col-xs-2">USERNAME</td>
						<td class="col-xs-2">EMAIL</td>
			            <td class="col-xs-1">CADASTRO</td>
			            <td class="col-xs-1">TELEFONE</td>
			            <td class="col-xs-1">CELULAR</td>
			            <td class="col-xs-1">PERFIL</td>
			            <td class="check col-xs-2"></td>
			        </tr>
				</thead>
				<tbody>			
		        <?php 
					foreach($linhas->result_array() as $linha){
						$row = "
							<tr class='dados row'>
								<td>$linha[nome]</td>
								<td>$linha[username]</td>
								<td>$linha[email]</td>
								<td>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha['cadastro']))."</td>
								<td>$linha[telefone]</td>
								<td>$linha[celular]</td>
								<td>$linha[nome_perfil]</td>
								<td class='buttons-row'>";

						if($isAdm == 't'){
							if($linha['perfilusuario_id'] != 2)
								$row .= "<a class='botaoPermissao' id='perm-$linha[usuario_id]' href='javascript:;' alt='Editar Permissões' title='Editar Permissões'><i class='fa fa-lock fa-2x'></i></a>";
							else
								$row .= "<a class='botaoPermissaoDesativado' alt='Não necessita permissões' title='Não necessita permissões' style='color: #666; cursor:arrow;'><i class='fa fa-lock fa-2x'></i></a>";
						}
						$row .= "<a class='botaoEditar' id='edit-$linha[usuario_id]' href='javascript:;' alt='Editar Registro' title='Editar Registro'><i class='fa fa-pencil-square-o fa-2x'></i></a>
									<a class='botaoExcluir' id='del-$linha[usuario_id]' href='javascript:;' alt='Excluir Registro' title='Excluir Registro'><i class='fa fa-times fa-2x'></i></a>
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