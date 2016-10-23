<?php
class CI_servidoresborda extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_servidoresborda');
		$this->load->model('M_usuarios');
		$this->load->model('M_servidorcontexto');
		$this->load->model('M_perfisusuarios');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
		if ($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["website_titulo"] != ""){
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
		$this->dados["linhas"] = $this->M_servidoresborda->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_servidoresborda->numeroLinhasTotais();
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
			$this->M_servidoresborda->setservidorbordaId($_POST["servidorborda_id"]);
			$this->M_servidoresborda->setservidorbordaNome($_POST["servidorborda_nome"]);
			$this->M_servidoresborda->setservidorbordaDesc($_POST["servidorborda_desc"]);
			$this->M_servidoresborda->setservidorbordaUrl($_POST["servidorborda_url"]);
			$this->M_servidoresborda->setservidorbordaAccessToken($_POST["servidorborda_access_token"]);
			$this->M_servidoresborda->setservidorbordaContexto('9');
			if ($this->M_servidoresborda->salvar() == "inc"){
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
				$this->M_servidoresborda->setservidorbordaId($_POST["item"]);	
				$this->M_servidoresborda->excluir();
			}
		}
		else{
			$this->M_servidoresborda->setservidorbordaId($id);	
			$this->M_servidoresborda->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_servidoresborda->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_servidoresborda->selecionar($valor);
		}	
		$this->cadastro();
	}

}
?>