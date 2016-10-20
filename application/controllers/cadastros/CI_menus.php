<?php
class CI_menus extends CI_controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
			if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
			    die();
			}
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_menus');
		$this->load->model('M_perfisusuarios');
		$this->load->model('M_usuarios');
		$this->load->model('M_relmenuperfil');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
		if (isset($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"])){
			$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];				
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
		$this->dados["linhas"] = $this->M_menus->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_menus->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Menus Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/menu/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["parentes"] = $this->M_menus->pesquisarParentes();
		$this->dados["perfis"] = $this->M_perfisusuarios->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/menu/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('menu_nome', 'Nome', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['menu_id'] != "") {
				$this->editar($_POST['menu_id']);
			} else {
				$this->cadastro();
			}
		} else	{
			$this->M_menus->setMenuId($_POST["menu_id"]);
			$this->M_menus->setMenuNome($_POST["menu_nome"]);
			$this->M_menus->setMenuParente($_POST["menu_parente"]);
			$this->M_menus->setMenuCaminho($_POST["menu_caminho"]);
			$this->M_menus->setMenuOrdem($_POST["menu_ordem"]);

			if ($this->M_menus->salvar() == "inc"){
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
				$this->M_menus->setMenuId($_POST["item"]);	
				$this->M_menus->excluir();
			}
		}
		else{
			$this->M_menus->setMenuId($id);	
			$this->M_menus->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_menus->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_menus->selecionar($valor);
		}
		$this->cadastro();
	}

}
?>