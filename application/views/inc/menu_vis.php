<section class="menu container-fluid">
	<div class="container">
		<div class="row">
    		<div class="col-xs-12">
    			<ul>
                    <?php if(!isset($index)){ ?>
    				<li>
    					<a href="<?php echo base_url(); ?>index.php/CI_visualizacao" title="">Início</a>
    				</li>
    				<li>
    					<a href="<?php echo base_url(); ?>index.php/CI_visualizacao/tabela">Tabela</a>
    				</li>
    				<li>
    					<a href="<?php echo base_url(); ?>index.php/CI_visualizacao/grafico">Gráfico</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/CI_visualizacao/comparar">Comparar</a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/CI_visualizacao/busca">Busca</a>
                    </li>
    			</ul>
    		</div>
		</div>
	</div>    	
</section>