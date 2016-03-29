
<div>
	<table class="tabela-agendamentos" cellspacing="0" cellpadding="3">
		<thead>
			<tr>
				<th>Usuário</th>
				<th>Ambiente</th>
				<th>Período Inicial</th>
				<th>Período Final</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($registro)){
				foreach ($registro->result() as $linha){
					echo "<tr>
						<td>".$linha->nome_usuario."</td>
						<td>".$linha->nome_ambiente."</td>
						<td>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha->datetimeinicial))."</td>
						<td>".mdate('%d' . '/' . '%m' .  '/' . '%Y', strtotime($linha->datetimefinal))."</td> 
					</tr>";
				}	
			}
		?>
		</tbody>
	</table>

</div>