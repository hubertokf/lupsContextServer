<?php
    @$gateway_status = 't';

	if(isset($registro)){
		foreach ($registro->result() as $linha){
			$gateway_id 			= $linha->gateway_id;
			$gateway_nome			= $linha->nome;
			$gateway_modelo			= $linha->modelo;
			$gateway_fabricante		= $linha->fabricante_id;
            $gateway_servidorborda          = $linha->servidorborda_id;
            $gateway_status         = $linha->status;
			$gateway_uuid			= $linha->uuid;
		}
	}
    
?>

<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./gravar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Cadastro de Gateways</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
                        <div class="row">
                            <div class="col-xs-1 col-xs-offset-1">
                                <label for="gateway_id">ID:</label>
                            </div>
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="gateway_id" readonly value="<?php echo @$gateway_id;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-1 col-xs-offset-1">
                                <label for="gateway_uuid">uuID:</label>
                            </div>
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="gateway_uuid"  value="<?php echo @$gateway_uuid;?>" />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="gateway_nome">Nome:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="gateway_nome" value="<?php echo @$gateway_nome;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="gateway_modelo">Modelo:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <input type="text" name="gateway_modelo" value="<?php echo @$gateway_modelo;?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="gateway_fabricante">Fabricante:</label>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<select name="gateway_fabricante">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($fabricantes->result() as $fabricante){
											if ($fabricante->fabricante_id==@$gateway_fabricante){
												$selected = "selected";
											}
											echo '<option value="'.$fabricante->fabricante_id.'" '.$selected.'>'.$fabricante->nome.'</option>';
											$selected = "";
										}
									?>
								</select>
							</div>
						</div>

						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="gateway_servidorborda">Servidor de borda:</label>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<select name="gateway_servidorborda">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										$selected = "";
										foreach ($servidorbordas->result() as $servidorborda){
											if ($servidorborda->servidorborda_id==@$gateway_servidorborda){
												$selected = "selected";
											}
											echo '<option value="'.$servidorborda->servidorborda_id.'" '.$selected.'>'.$servidorborda->nome.'</option>';
											$selected = "";
										}
									?>
								</select>
							</div>
						</div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="gateway_status">Status:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <select name="gateway_status">
                                    <option value="t" <?php if(@$gateway_status == 't') echo"selected"; ?> >Ativado</option>
                                    <option value="f" <?php if(@$gateway_status == 'f') echo"selected"; ?> >Desativado</option>
                                </select>
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