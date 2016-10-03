<?php
class CI_ambientes extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_ambientes');
		$this->load->model('M_gateways');
		$this->load->model('M_usuarios');
		$this->load->model('M_sensores');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
			$this->dados['isLoged'] = true;
			$this->dados['usuario_logado'] = $this->session->userdata('nome');
		}else
			$this->dados['isLoged'] = false;
		$this->dados['title'] = "Gerenciador de ambientes";
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{	
		$this->pesquisa();
	}
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";

		if ($this->session->userdata('perfilusuario_id') == 2)
			$this->dados["linhas"] = $this->M_ambientes->pesquisar('', array(), $nr_pagina, $this->uri->segment(5), 'asc', FALSE);
		else
			$this->dados["linhas"] = $this->M_ambientes->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE);

		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_ambientes->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Ambientes Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/ambiente/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["gateways"] = $this->M_gateways->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/ambiente/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('ambiente_nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('ambiente_status', 'Status', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['ambiente_id'] != "") {
				$this->editar($_POST['ambiente_id']);	
			} else {	
				$this->cadastro();
			}
		}
		else
		{
			$this->M_ambientes->setAmbienteId($_POST["ambiente_id"]);
			$this->M_ambientes->setAmbienteNome($_POST["ambiente_nome"]);
			$this->M_ambientes->setAmbienteDesc($_POST["ambiente_desc"]);
			$this->M_ambientes->setAmbienteStatus($_POST["ambiente_status"]);
			if ($this->M_ambientes->salvar() == "inc"){
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}
	}
	
	function excluir($id=""){
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_ambientes->setAmbienteId($_POST["item"]);	
				$this->M_ambientes->excluir();
			}
		}
		else{
			$this->M_ambientes->setAmbienteId($id);	
			$this->M_ambientes->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_ambientes->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_ambientes->selecionar($valor);	
		}
		$this->cadastro();
	}

	function ativar($id="") {
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_ambientes->setAmbienteId($_POST["item"]);	
				$this->M_ambientes->setAmbienteStatus('true');
				$sensor_list = $this->M_sensores->pesquisar('', array('s.ambiente_id'=>$_POST["item"]), 100000, 0, 'asc', FALSE);
				foreach ($sensor_list->result_array() as $key => $sensor) {
					$this->M_sensores->setSensorId($sensor['sensor_id']);	
					$this->M_sensores->setSensorStatus('true');	
					$this->M_sensores->altStatus();
				}
				$this->M_ambientes->altStatus();
			}
		}
		else{
			$this->M_ambientes->setAmbienteId($id);	
			$this->M_ambientes->setAmbienteStatus('true');
			$sensor_list = $this->M_sensores->pesquisar('', array('s.ambiente_id'=>$_POST["item"]), 100000, 0, 'asc', FALSE);
			foreach ($sensor_list->result_array() as $key => $sensor) {
				$this->M_sensores->setSensorId($sensor['sensor_id']);	
				$this->M_sensores->setSensorStatus('true');	
				$this->M_sensores->altStatus();
			}
			$this->M_ambientes->altStatus();
		}
		$this->dados["msg"] = "ambiente ativado com sucesso!";
		$this->pesquisa();
	}

	function desativar($id="") {

		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_ambientes->setAmbienteId($_POST["item"]);
				$this->M_ambientes->setAmbienteStatus('false');
				$sensor_list = $this->M_sensores->pesquisar('', array('s.ambiente_id'=>$_POST["item"]), 100000, 0, 'asc', FALSE);
				foreach ($sensor_list->result_array() as $key => $sensor) {
					$this->M_sensores->setSensorId($sensor['sensor_id']);	
					$this->M_sensores->setSensorStatus('false');	
					$this->M_sensores->altStatus();
				}
				$this->M_ambientes->altStatus();
			}
		}
		else{
			$this->M_ambientes->setAmbienteId($id);	
			$this->M_ambientes->setAmbienteStatus('false');	
			$sensor_list = $this->M_sensores->pesquisar('', array('s.ambiente_id'=>$id), 100000, 0, 'asc', FALSE);
			foreach ($sensor_list->result_array() as $key => $sensor) {
				$this->M_sensores->setSensorId($sensor['sensor_id']);	
				$this->M_sensores->setSensorStatus('false');	
				$this->M_sensores->altStatus();
			}
			$this->M_ambientes->altStatus();
		}
		$this->dados["msg"] = "ambiente desativado com sucesso!";
		$this->pesquisa();
	}
	
	function select(){
		$registros = $this->M_ambientes->pesquisar()->result_array();

	    echo json_encode($registros);
	}
}
?>