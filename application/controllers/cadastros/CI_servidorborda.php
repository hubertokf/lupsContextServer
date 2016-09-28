<?php
class CI_servidorborda extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_servidorborda');
		$this->load->model('M_usuario');
		$this->load->model('M_servidorcontexto');
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
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";
		$this->dados["linhas"] = $this->M_servidorborda->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_servidorborda->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Servidores de Borda Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/servidorborda/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/servidorborda/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('servidorborda_nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('servidorborda_url', 'URL', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			if ($_POST['servidorborda_id'] != "") {
				$this->editar($_POST['servidorborda_id']);
			} else {
				$this->cadastro();
			}
			
		} else {
			$this->M_servidorborda->setservidorbordaId($_POST["servidorborda_id"]);
			$this->M_servidorborda->setservidorbordaNome($_POST["servidorborda_nome"]);
			$this->M_servidorborda->setservidorbordaDesc($_POST["servidorborda_desc"]);
			$this->M_servidorborda->setservidorbordaUrl($_POST["servidorborda_url"]);
			$this->M_servidorborda->setservidorbordaAccessToken($_POST["servidorborda_access_token"]);
			$this->M_servidorborda->setservidorbordaLatitude($_POST["servidorborda_latitude"]);
			$this->M_servidorborda->setservidorbordaLongitude($_POST["servidorborda_longitude"]);
			$this->M_servidorborda->setservidorbordaContexto('9');
			if ($this->M_servidorborda->salvar() == "inc"){
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
				$this->M_servidorborda->setservidorbordaId($_POST["item"]);	
				$this->M_servidorborda->excluir();
			}
		}
		else{
			$this->M_servidorborda->setservidorbordaId($id);	
			$this->M_servidorborda->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_servidorborda->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_servidorborda->selecionar($valor);
		}	
		$this->cadastro();
	}

}
?>