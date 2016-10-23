<?php
class CI_tipossensores extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_tipossensores');
		$this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
		if ($this->session->userdata('usuario_id') != null && $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["website_titulo"] != ""){
			$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["website_titulo"];				
		}else{
			$this->dados['title'] = $this->M_configuracoes->selecionar('titulo')->result_array()[0]["value"];
		}
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{	
		$this->pesquisa();
	}
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";
		$this->dados["linhas"] = $this->M_tipossensores->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_tipossensores->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Tipos de Sensores Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/tipo_sensor/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/tipo_sensor/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('tiposensor_nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('tiposensor_unidade', 'Unidade', 'trim|required');
		$this->form_validation->set_rules('tiposensor_tipo', 'Tipo', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			if ($_POST['tiposensor_id'] != "") {
				$this->editar($_POST['tiposensor_id']);	
			} else {	
				$this->cadastro();
			}			
		} else {
			$this->M_tipossensores->setTipoSensorId($_POST["tiposensor_id"]);
			$this->M_tipossensores->setTipoSensorNome($_POST["tiposensor_nome"]);
			$this->M_tipossensores->setTipoSensorDesc($_POST["tiposensor_desc"]);
			$this->M_tipossensores->setTipoSensorTipo($_POST["tiposensor_tipo"]);
			$this->M_tipossensores->setTipoSensorUnidade($_POST["tiposensor_unidade"]);
			if ($this->M_tipossensores->salvar() == "inc"){
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
				$this->M_tipossensores->setTipoSensorId($_POST["item"]);	
				$this->M_tipossensores->excluir();
			}
		}
		else{
			$this->M_tipossensores->setTipoSensorId($id);	
			$this->M_tipossensores->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_tipossensores->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_tipossensores->selecionar($valor);
		}
		$this->cadastro();
	}

}
?>