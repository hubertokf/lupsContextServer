<?php
class CI_contextointeresse extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_contextointeresse');
		$this->load->model('M_relcontextointeresse');
		$this->load->model('M_servidorcontexto');
		$this->load->model('M_sensor');
		$this->load->model('M_regras');
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

	function index(){	
		$this->pesquisa();
	}
	
	function pesquisa($nr_pagina=10){
		$this->dados["metodo"] = "pesquisa";

		if ($this->session->userdata('perfilusuario_id') == 2)
			$this->dados["linhas"] = $this->M_contextointeresse->pesquisar('', array(), $nr_pagina, $this->uri->segment(5), 'asc', FALSE);
		else
			$this->dados["linhas"] = $this->M_contextointeresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE);

		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_contextointeresse->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Contextos de Interesses Cadastrados";
		$pag['base_url'] = base_url."index.php/".$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
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
		if ($this->session->userdata('perfilusuario_id') == 2)
			$this->dados["sensores"] = $this->M_sensor->pesquisar($select='', $where=array(), $limit=100, $offset=0, $ordem='asc');
		else
			$this->dados["sensores"] = $this->M_sensor->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);
		
		$this->dados["regras"] = $this->M_regras->pesquisar();
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
			$this->M_contextointeresse->setContextoInteresseId($_POST["contextointeresse_id"]);
			$this->M_contextointeresse->setContextoInteresseNome($_POST["contextointeresse_nome"]);
			$this->M_contextointeresse->setContextoInteresseServidorContexto('9');
			$this->M_contextointeresse->setContextoInteresseSensores($_POST["contextointeresse_sensores"]);
			$this->M_contextointeresse->setContextoInteresseRegra(isset($_POST["contextointeresse_regra"]) ? $_POST["contextointeresse_regra"] : null);
			$this->M_contextointeresse->setContextoInteresseTrigger(isset($_POST["contextointeresse_trigger"]) ? $_POST["contextointeresse_trigger"] : null);
			if (isset($_POST["contextointeresse_publico"])){
				$this->M_contextointeresse->setContextoInteressePublico("TRUE");
			}else{
				$this->M_contextointeresse->setContextoInteressePublico("FALSE");
			}

			if ($this->M_contextointeresse->salvar() == "inc"){
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
				$this->M_contextointeresse->setContextoInteresseId($_POST["item"]);	
				$this->M_contextointeresse->excluir();
			}
		
		}else{
			$this->M_contextointeresse->setContextoInteresseId($id);	
			$this->M_contextointeresse->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {

		
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_contextointeresse->selecionar($_POST["item"]);
			$this->dados["trigger"] = $this->M_relcontextointeresse->getChkByCi($_POST["item"]);
			
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_contextointeresse->selecionar($valor);
			$this->dados["trigger"] = $this->M_relcontextointeresse->getChkByCi($valor);
			
		}
		$this->cadastro();
	}

	function select(){
		$registros = $this->M_contextointeresse->pesquisar();

	    echo json_encode($registros);
	}

}
?>