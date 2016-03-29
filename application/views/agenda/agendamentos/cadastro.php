<?php
	$usuarioId = $this->session->userdata('usuario_id');
	$usuarioNome = $this->session->userdata('nome');
	$usuarioPerfil = $this->session->userdata('perfilusuario_id');
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$agendamento_id 				= $linha->agendamento_id;
			$agendamento_desc 				= $linha->descricao;
			$agendamento_ambiente			= $linha->ambiente_id;
			$agendamento_datetimeinicial	= $linha->datetimeinicial;
			$agendamento_datetimefinal		= $linha->datetimefinal;
			$agendamento_usuario			= $linha->usuario_id;
		}
	}
?>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/calendar.js"></script>
<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" class="formulario-agendamento" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Agendamentos</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" id="agendamento_id" name="agendamento_id" value="<?php echo @$agendamento_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="agendamento_usuario">Usuário</label>
                            </div>
                        </div>
                        <div class="row">
                        	<?php if ((int)$usuarioPerfil <= 2) { ?>
	                            <div class="col-xs-10 col-xs-offset-1">
	                                <select name="agendamento_usuario">
										<option value="" selected="" disabled="">Selecione...</option>
										<?php
											$selected = "";
											foreach ($usuario->result() as $linha){
												if ($linha->usuario_id==@$agendamento_usuario){
													$selected = "selected";
												}
												echo '<option value="'.$linha->usuario_id.'" '.$selected.'>'.$linha->nome.'</option>';
												$selected = "";
											}
										?>
									</select>
	                            </div>
	                        <?php } else { ?>
	                        	<div class="col-xs-10 col-xs-offset-1 input">
		                        	<input type="text" name="usuario_tela" readonly="readonly" value="<?php echo $usuarioNome; ?>" />
				                	<input type="hidden" name="agendamento_usuario" value="<?php echo $usuarioId; ?>" />
				                </div>
							<?php } ?>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input-select">
                                <label for="agendamento_ambiente">Ambiente</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="agendamento_ambiente" id="agendamento_ambiente">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($ambiente->result() as $linha){
											if ($linha->ambiente_id==@$agendamento_ambiente){
												$selected = "selected";
											}
											echo '<option value="'.$linha->ambiente_id.'" '.$selected.'>'.$linha->nome.'</option>';
											$selected = "";
										}
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="agendamento_desc">Descrição</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="agendamento_desc" value="<?php echo @$agendamento_desc;?>" />
                            </div>
                        </div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<fieldset>
									<legend>Período de utilização</legend>
									<div class="col-xs-6">
										<input readonly="readonly" type="text" id="dt-inicio" name="agendamento_datetimeinicial" value="<?php echo @$agendamento_datetimeinicial;?>" />
									</div>
									<div class="col-xs-6">
		                				<input readonly="readonly" type="text" id="dt-final" name="agendamento_datetimefinal" value="<?php echo @$agendamento_datetimefinal;?>" />
									</div>
								</fieldset>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<div class="erro-login-msg">
									<?php echo validation_errors(); ?>
								</div>
							</div>
						</div> 
                        <div class="row">
                            <div class="submit">
                                <div class="col-md-10 col-md-offset-1">
                                    <input type="button" name="botao" value="Cadastrar" class="btn-cadastro-agendamento" />
                                </div>          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>