<?php

class CI_topico extends CI_controller {
	 // faz a interoperação de regra entre o metodo editar com o sendInformation
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_topico');
		$this->load->model('M_geral');
		$this->load->model('M_usuarios');
		$this->load->model('M_configuracoes');


		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
			$this->dados['isLoged'] = true;
			$this->dados['usuario_logado'] = $this->session->userdata('nome');
		}else
			$this->dados['isLoged'] = false;
		$this->dados['title'] = "Gerenciador de Servidor de Contexto";
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{
		$this->pesquisa();
	}

	function select(){
		$registros = $this->M_regras->pesquisar()->result_array();
	  echo json_encode($registros);
	}

	function pesquisa($nr_pagina=20 ){
		if(isset($_GET["msg"])){
			$this->dados["msg"] = $_GET["msg"];
		}
		// $this->dados["msg"] =
		$this->dados["metodo"] = "pesquisa";

		$this->dados["linhas"] = $this->M_topico->pesquisar('', array(), $nr_pagina,  $this->uri->segment(5), 'asc');


		$this->dados["nr_pagina"]      = $nr_pagina;
		$this->dados["total"]          = $this->M_topico->numeroLinhasTotais('',array());

		$this->dados["tituloPesquisa"] = "Topicos Cadastradas";
		$pag['base_url']    = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows']  = $this->dados["total"];

		$pag['uri_segment']	= 5;

		$pag['per_page']    = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag);
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');

		$this->load->view('cadastros/topicos/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro($value = ""){

		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/topicos/cadastro');
		$this->load->view('inc/rodape');

	}

	function gravar($nr_pagina=20){
		$this->form_validation->set_rules('topico_nome', 'Nome', 'trim|required|is_unique[topicos.nome]');

		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');

		if ($this->form_validation->run() == FALSE) {
			if ($_POST['topico_id'] != "") {
				$this->editar($_POST['topico_id']);
			} else {
				$this->cadastro();
			}

		} else {
			//($st, NULL, FALSE);
			 //'nome == ' + $_POST["topico_nome"]
			//$st="infor='rent' AND (typeq='in' OR typeq='out')";
			//$st = 'nome == \''+$_POST["topico_nome"]+'\'';
			$st = array('nome' => $_POST["topico_nome"]);

			if (!empty($this->M_topico->pesquisar('', $st, $nr_pagina,  $this->uri->segment(5), 'asc')->result_array())){
				//print_r($this->M_topico->pesquisar('', $st, $nr_pagina,  $this->uri->segment(5), 'asc')->result_array());
				$this->dados["msg"] = "Dado existe no DB!";
				$this->pesquisa();
			}
			else{
				$this->M_topico->set_nome_topico($_POST["topico_nome"]);

				if ($this->M_topico->salvar() == "inc"){
					$this->dados["msg"] = "Dados registrados com sucesso!";
					$this->pesquisa();
				}
				else {
					$this->dados["msg"] = "Dados alterados com sucesso!";
					$this->pesquisa();
				}
			}
		}
	}

	function excluir($id=""){
		//echo $_POST["item"];
		if ($id==""){
			if(isset($_POST["item"])) { //Item referente a cada item da lista de pesquisa
				$this->M_topico->set_id_topico($_POST["item"]);
				$this->M_topico->excluir();
				//echo "if";
			}
		}
		else{
			$this->M_topico->set_id_topico($id);
			$this->M_topico->excluir();
			//echo "else";
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

	function editar($valor = "") {

		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_topico->selecionar($_POST["item"]);
	 	} else if ($valor != "") {
			$this->dados["registro"] = $this->M_topico->selecionar($valor);
	 	}
	 	$this->cadastro();
 }




}

?>
