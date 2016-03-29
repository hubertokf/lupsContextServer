<section class="cadastros telaCadastro">
    <div class="container">
        <form name="formRelatorio" id="formRelatorio" method="post" action="./gerarRelatorio" target="_blank">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tituloCadastros">
                        <h2>Selecione o tipo de relatório</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="cadastro-box">
		            	<input type="hidden" name="agendamento_id" value="<?php echo @$agendamento_id;?>">
                        
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 input">
                                <label for="agendamento_usuario">Usuário</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <select name="agendamento_usuario">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										foreach ($usuario->result() as $linha){
											echo '<option value="'.$linha->usuario_id.'">'.$linha->nome.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <label for="agendamento_ambiente">Ambiente</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <select name="agendamento_ambiente">
									<option value="" selected="" disabled="">Selecione...</option>
									<?php
										foreach ($ambiente->result() as $linha){
											echo '<option value="'.$linha->ambiente_id.'">'.$linha->nome.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="submit">
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="submit" name="botao" value="Gerar Relatório" />
                                </div>          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>