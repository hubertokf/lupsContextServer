<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formCadastro" id="formCadastro" method="post" action="./visualizar">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Selecione um Ambiente</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" id="agendamento_id" name="agendamento_id" value="<?php echo @$agendamento_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="agendamento_ambiente">Ambiente</label>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-10 col-xs-offset-1">
                                <select name="agendamento_ambiente">
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
                            <div class="submit">
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="submit" name="botao" value="Selecionar" />
                                </div>          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>