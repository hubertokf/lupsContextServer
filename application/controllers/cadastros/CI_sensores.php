<?php
class CI_sensores extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_sensores');
		$this->load->model('M_usuarios');
		$this->load->model('M_fabricantes');
		$this->load->model('M_tipossensores');
		$this->load->model('M_ambientes');
		$this->load->model('M_gateways');
		$this->load->model('M_servidoresborda');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
		if (isset($this->M_configuracoes->selByUser($this->session->userdata('usuario_id'))->result_array()[0]["titulo"]))
			$this->dados['title'] = $this->M_configuracoes->selByUser($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];
		else
			$this->dados['title'] = $title = $this->M_configuracoes->selecionar(1)->result_array()[0]["titulo"];
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{	
		$this->pesquisa();
	}

	function select(){
		$registros = $this->M_sensores->pesquisar()->result_array();

	    echo json_encode($registros);
	}
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";
		$this->dados["sb"] = $this->M_servidoresborda->pesquisar('', array(), 1000);
		if (isset($_POST["pesquisa_filter"]) && $_POST["pesquisa_filter"]!= ""){
			if ($this->session->userdata('perfilusuario_id') == 2)
				$this->dados["linhas"] = $this->M_sensores->pesquisar('', array("s.servidorborda_id" => $_POST["pesquisa_filter"]), $nr_pagina, $this->uri->segment(5));
			else
				$this->dados["linhas"] = $this->M_sensores->pesquisar('', array("s.servidorborda_id" => $_POST["pesquisa_filter"], 'p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE);
		}else{
			if ($this->session->userdata('perfilusuario_id') == 2)
				$this->dados["linhas"] = $this->M_sensores->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
			else
				$this->dados["linhas"] = $this->M_sensores->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE);
		}
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_sensores->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Sensores Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/sensor/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["fabricantes"] = $this->M_fabricantes->pesquisar();
		$this->dados["tiposensores"] = $this->M_tipossensores->pesquisar();
		$this->dados["ambientes"] = $this->M_ambientes->pesquisar();
		$this->dados["gateways"] = $this->M_gateways->pesquisar();
		$this->dados["bordas"] = $this->M_servidoresborda->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/sensor/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('sensor_nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('sensor_tipo', 'Tipo', 'trim|required');
		$this->form_validation->set_rules('sensor_servidorborda', 'Servidor de borda', 'trim|required');
		$this->form_validation->set_rules('sensor_status', 'Status', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['sensor_id'] != "") {
				$this->editar($_POST['sensor_id']);	
			} else {	
				$this->cadastro();
			}
		}
		else
		{
			$this->M_sensores->setSensorId($_POST["sensor_id"]);
			$this->M_sensores->setSensorNome($_POST["sensor_nome"]);
			$this->M_sensores->setSensorDesc($_POST["sensor_desc"]);
			$this->M_sensores->setSensorModelo($_POST["sensor_modelo"]);
			$this->M_sensores->setSensorPrecisao(isset($_POST["sensor_precisao"]) ? $_POST["sensor_precisao"] : null);

			$this->M_sensores->setSensorValorMin(isset($_POST["sensor_valormin"]) ? $_POST["sensor_valormin"] : null);
			$this->M_sensores->setSensorValorMax(isset($_POST["sensor_valormax"]) ? $_POST["sensor_valormax"] : null);

			$this->M_sensores->setSensorValorMin_n(isset($_POST["sensor_valormin_n"]) ? $_POST["sensor_valormin_n"] : null);
			$this->M_sensores->setSensorValorMax_n(isset($_POST["sensor_valormax_n"]) ? $_POST["sensor_valormax_n"] : null);

			$this->M_sensores->setSensorInicioLuz(isset($_POST["sensor_inicio_luz"]) ? $_POST["sensor_inicio_luz"] : null);
			$this->M_sensores->setSensorFimLuz(isset($_POST["sensor_fim_luz"]) ? $_POST["sensor_fim_luz"] : null);

			$this->M_sensores->setSensorFabricante(isset($_POST["sensor_fabricante"]) ? $_POST["sensor_fabricante"] : null);
			$this->M_sensores->setSensorTipo($_POST["sensor_tipo"]);
			$this->M_sensores->setSensorAmbiente(isset($_POST["sensor_ambiente"]) ? $_POST["sensor_ambiente"] : null);
			$this->M_sensores->setSensorGateway($_POST["sensor_gateway"]);
			$this->M_sensores->setSensorServidorBorda($_POST["sensor_servidorborda"]);
			$this->M_sensores->setSensorStatus($_POST["sensor_status"]);

			if ($this->M_sensores->salvar() == "inc"){
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}	
	}

	function gravaSensor(){
		$this->M_sensores->setSensorNome($_POST["sensor_nome"]);
		$this->M_sensores->setSensorDesc($_POST["sensor_desc"]);
		$this->M_sensores->setSensorModelo($_POST["sensor_modelo"]);
		$this->M_sensores->setSensorPrecisao($_POST["sensor_precisao"]);
		//$this->M_sensores->setSensorTipo($_POST["sensor_tipo"]); //<----
		$this->M_sensores->setSensorGateway($_POST["sensor_gateway"]);
		$this->M_sensores->setSensorServidorBorda($_POST["sensor_servidorborda"]);
		$sensorID = $this->M_sensores->salvaSensor();

		echo $sensorID;
	}
	
	function excluir($id=""){
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_sensores->setSensorId($_POST["item"]);	
				$this->M_sensores->excluir();
			}
		}
		else{
			$this->M_sensores->setSensorId($id);	
			$this->M_sensores->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_sensores->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_sensores->selecionar($valor);
		}
		$this->cadastro();
	}

	function getSensoresBySBID($id=""){
		if ($id==""){	
			if(isset($_POST["servidorborda"])) {
				$sensores = $this->M_sensores->getBySBid($_POST["servidorborda"]);
			}
		}else{
			$sensores = $this->M_sensores->getBySBid($id);
		}

	    echo json_encode($sensores);
	}

	function ativar($id="", $silent = false) {
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_sensores->setSensorId($_POST["item"]);	
				$this->M_sensores->setSensorStatus('true');
				$ambiente = $this->M_sensores->selecionar($_POST["item"])->result_array();
				$this->M_ambientes->setAmbienteId($ambiente[0]['ambiente_id']);	
				$this->M_ambientes->setAmbienteStatus('true');	
				$this->M_ambientes->altStatus();
				$this->M_sensores->altStatus();
			}
		}
		else{
			$this->M_sensores->setSensorId($id);	
			$this->M_sensores->setSensorStatus('true');
			$ambiente = $this->M_sensores->selecionar($_POST["item"])->result_array();
			$this->M_ambientes->setAmbienteId($ambiente[0]['ambiente_id']);	
			$this->M_ambientes->setAmbienteStatus('true');	
			$this->M_ambientes->altStatus();	
			$this->M_sensores->altStatus();
		}

		if($silent != true){
			$this->dados["msg"] = "Sensor ativado com sucesso!";
			$this->pesquisa();
		}
	}

	function desativar($id="", $silent = false) {

		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_sensores->setSensorId($_POST["item"]);
				$this->M_sensores->setSensorStatus('false');
				$this->M_sensores->altStatus();
			}
		}
		else{
			$this->M_sensores->setSensorId($id);	
			$this->M_sensores->setSensorStatus('false');	
			$this->M_sensores->altStatus();
		}

		if($silent != true){
			$this->dados["msg"] = "Sensor desativado com sucesso!";
			$this->pesquisa();
		}
	}
}
?>
