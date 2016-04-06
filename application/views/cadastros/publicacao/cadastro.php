<?php
	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$publicacao_id 				=	$linha->publicacao_id;
			$publicacao_servidorborda			=	$linha->servidorborda_id;
			$publicacao_sensor			=	$linha->sensor_id;
			$publicacao_datacoleta		=	$linha->datacoleta;
			$publicacao_datapublicacao	=	$linha->datapublicacao;
			$publicacao_valorcoletado	=	$linha->valorcoletado;
		}
	}
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formPergunta" id="formPergunta" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Publicações</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" name="publicacao_id" value="<?php echo @$publicacao_id;?>">

						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="publicacao_servidorborda">Servidor de borda:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="publicacao_servidorborda" id="publicacao_servidorborda">
									<option value="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($servidorbordas->result() as $servidorborda){
											if ($servidorborda->servidorborda_id==@$publicacao_servidorborda){
												$selected = "selected";
											}
											echo '<option value="'.$servidorborda->servidorborda_id.'" '.$selected.'>'.$servidorborda->nome.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="publicacao_sensor">Sensor:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="hidden" id="sel_publicacao_sensor" value="<?php echo @$publicacao_sensor;?>">
                                <select name="publicacao_sensor" id="publicacao_sensor">
                                    <option value="" selected="" disabled="">Selecione um Servidor de Borda</option>
                                </select>
                            </div>
                        </div>
                        
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <label for="publicacao_datacoleta">Data Coleta</label>
                            </div>
                            <div class="col-xs-5">
                                <label for="publicacao_datapublicacao">Data Publicação</label>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-5 col-xs-offset-1">								
								<input readonly="readonly" type="text" id="dt-coleta" name="publicacao_datacoleta" value="<?php echo @$publicacao_datacoleta;?>" />	
							</div>
							<div class="col-xs-5">
								<input readonly="readonly" type="text" id="dt-publicacao" name="publicacao_datapublicacao" value="<?php echo @$publicacao_datapublicacao;?>" />
							</div>
						</div>
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="publicacao_valorcoletado">Valor</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="publicacao_valorcoletado" value="<?php echo @$publicacao_valorcoletado;?>" />
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
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="submit" name="botao" value="Cadastrar" />
                                </div>          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>