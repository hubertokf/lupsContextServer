<section class="visAgendamento">
	<div class="container">
		<div class="row">
            <div class="col-xs-12">
                <div class="titulo">
                    <h2>Agendamentos Registrados</h2>
                </div>
            </div>
        </div>

        <div class="row">
        	<div class="col-sm-6">
        		<div class="calendario">
        			<?php echo $calendario;?>
        		</div>
        	</div>

        	<div class="col-sm-6">
        		<div class="calendarioLegenda">
        			<h2>Legenda</h2>	
        			<ul>
        				<li>
        					<span class="block-legenda">
        						<span class="legenda-square legenda-dia-atual bloco-legenda-agendamento">1</span> - Dia atual
        					</span>	
        					<span class="block-legenda">
        						<span class="legenda-square legenda-gray bloco-legenda-agendamento">1</span> - 1 agendamento
        					</span>	
        				</li>
        				<li>
        					<span class="block-legenda">
        						<span class="legenda-square legenda-blue bloco-legenda-agendamento">1</span> - 1 agendamento
        					</span>	
    						<span class="block-legenda">
    							<span class="legenda-square legenda-green bloco-legenda-agendamento">1</span> - 2 agendamentos
    						</span>	
        				</li>
        				<li>
        					<span class="block-legenda">
        						<span class="legenda-square legenda-red bloco-legenda-agendamento">1</span> - 3/+ agendamentos
        					</span>	
        				</li>
        			</ul>
        		</div>

                <div class="col-sm-12">
                    <h4>Agendamentos do dia</h4>
                    <p>Clique em algum dos dias destacados do calendário para visualizar os agendamentos, cor igual na sequência significa que se refere ao mesmo agendamento.</p>
                    <div id="container-resultados-eventos"><!-- --></div>
                </div>
        	</div>
        </div>

        <div class="row">
        	
        </div>
	</div>
</section>