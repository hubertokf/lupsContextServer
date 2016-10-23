<?php
class CI_contextosinteresse extends CI_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_contextosinteresse');
		$this->load->model('M_relcontextointeresse');
		$this->load->model('M_servidorcontexto');
		$this->load->model('M_sensores');
		$this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
		$this->load->model('M_regras');
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

	function index(){
		$this->pesquisa();
	}

	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";

		$perfilusuario_id = $this->session->userdata('perfilusuario_id');
		$this->dados["isAdm"] = $this->M_perfisusuarios->isAdm($perfilusuario_id);
		if ($this->dados["isAdm"] == 't')
			$this->dados["linhas"] = $this->M_contextosinteresse->pesquisar('', array(), $nr_pagina, $this->uri->segment(5), 'asc', FALSE);
		else
			$this->dados["linhas"] = $this->M_contextosinteresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE);

		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_contextosinteresse->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Contextos de Interesses Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag);
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/contextointeresse/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$perfilusuario_id = $this->session->userdata('perfilusuario_id');
		if ($this->M_perfisusuarios->isAdm($perfilusuario_id) == 't')
			$this->dados["sensores"] = $this->M_sensores->pesquisar($select='', $where=array(), $limit=100, $offset=0, $ordem='asc');
		else
			$this->dados["sensores"] = $this->M_sensores->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);

		$this->dados["regras"] = $this->M_regras->pesquisar('',array('r.tipo '=>3),'','', '', '','',array('r.tipo '=>1));
		// print_r($this->dados["regras"]->result_array());
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/contextointeresse/cadastro');
		$this->load->view('inc/rodape');
	}

	function gravar(){
		$this->form_validation->set_rules('contextointeresse_sensores[]', 'Sensores', 'required');
		$this->form_validation->set_rules('contextointeresse_nome', 'Nome', 'required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['contextointeresse_id'] != "") {
				$this->editar($_POST['contextointeresse_id']);
			} else {
				$this->cadastro();
			}
		} else	{
			$this->M_contextosinteresse->setContextoInteresseId($_POST["contextointeresse_id"]);
			$this->M_contextosinteresse->setContextoInteresseNome($_POST["contextointeresse_nome"]);
			$this->M_contextosinteresse->setContextoInteresseServidorContexto('9');
			$this->M_contextosinteresse->setContextoInteresseSensores($_POST["contextointeresse_sensores"]);
			$this->M_contextosinteresse->setContextoInteresseRegra(isset($_POST["contextointeresse_regra"]) ? $_POST["contextointeresse_regra"] : null);
			$this->M_contextosinteresse->setContextoInteresseTrigger(isset($_POST["contextointeresse_trigger"]) ? $_POST["contextointeresse_trigger"] : null);
			if (isset($_POST["contextointeresse_publico"])){
				$this->M_contextosinteresse->setContextoInteressePublico("TRUE");
			}else{
				$this->M_contextosinteresse->setContextoInteressePublico("FALSE");
			}

			if ($this->M_contextosinteresse->salvar() == "inc"){
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
				$this->M_contextosinteresse->setContextoInteresseId($_POST["item"]);
				$this->M_contextosinteresse->excluir();
			}

		}else{
			$this->M_contextosinteresse->setContextoInteresseId($id);
			$this->M_contextosinteresse->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {


		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_contextosinteresse->selecionar($_POST["item"]);
			$this->dados["trigger"] = $this->M_relcontextointeresse->getChkByCi($_POST["item"]);

		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_contextosinteresse->selecionar($valor);
			$this->dados["trigger"] = $this->M_relcontextointeresse->getChkByCi($valor);

		}
		$this->cadastro();
	}

	function select(){
		$registros = $this->M_contextosinteresse->pesquisar('', array(), 10000, 0, 'asc', FALSE);

	    echo json_encode($registros);
	}

}
?>
