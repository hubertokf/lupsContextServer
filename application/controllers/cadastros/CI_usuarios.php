<?php
class CI_usuarios extends CI_controller {

	public function __construct()
	{
		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		    die();
		}
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
		$this->load->model('M_keys');
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
		$this->dados["linhas"] = $this->M_usuarios->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$perfilusuario_id = $this->session->userdata('perfilusuario_id');
		$this->dados["isAdm"] = $this->M_perfisusuarios->isAdm($perfilusuario_id);
		$this->dados["total"] = $this->M_usuarios->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Usuários Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/usuario/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["perfis"] = $this->M_perfisusuarios->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/usuario/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('usuario_perfil', 'Perfil', 'trim|required');
		$this->form_validation->set_rules('usuario_nome', 'Nome', 'trim|required|callback_username_check');
		$this->form_validation->set_rules('usuario_username', 'Username', 'trim|required');
		$this->form_validation->set_rules('usuario_email', 'Email', 'trim|required');
		$this->form_validation->set_rules('usuario_telefone', 'Telefone');
		$this->form_validation->set_rules('usuario_celular', 'Celular');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['usuario_id'] != "") {
				$this->editar($_POST['usuario_id']);
			} else {
				$this->cadastro();
			}
		}	else	{
			$this->M_usuarios->setUsuarioId($_POST["usuario_id"]);
			$this->M_usuarios->setUsuarioPerfil($_POST["usuario_perfil"]);
			$this->M_usuarios->setUsuarioNome($_POST["usuario_nome"]);
			$this->M_usuarios->setUsuarioUsername($_POST["usuario_username"]);
			if (isset($_POST["usuario_password"])){
				$passwordHash = password_hash($_POST["usuario_password"], PASSWORD_DEFAULT);
				$this->M_usuarios->setUsuarioPassword($passwordHash);
			}
			$this->M_usuarios->setUsuarioEmail($_POST["usuario_email"]);
			$this->M_usuarios->setUsuarioTelefone($_POST["usuario_telefone"]);
			$this->M_usuarios->setUsuarioCelular($_POST["usuario_celular"]);
			$this->M_usuarios->setUsuarioWebsiteTitulo(isset($_POST["usuario_website_titulo"]) ? $_POST["usuario_website_titulo"] : null);
			$this->M_usuarios->setUsuarioImgCabecalho(isset($_POST["usuario_img_cabecalho"]) ? $_POST["usuario_img_cabecalho"] : null);
			$this->M_usuarios->setUsuarioImgProjeto(isset($_POST["usuario_img_projeto"]) ? $_POST["usuario_img_projeto"] : null);
			$this->M_usuarios->setUsuarioCorPredominante(isset($_POST["usuario_cor_predominante"]) ? $_POST["usuario_cor_predominante"] : null);
			$this->M_usuarios->setUsuarioTituloProjeto(isset($_POST["usuario_titulo_projeto"]) ? $_POST["usuario_titulo_projeto"] : null);
			if (isset($_POST["token"]) && $_POST["token"]!=""){
				$this->M_usuarios->setUsuarioToken($_POST["token"]);
			}else{
				$token = json_decode($this->M_keys->insert_key(10))->key;
				$this->M_usuarios->setUsuarioToken($token);
			}

			if ($this->M_usuarios->salvar() == "inc"){
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}	
	}
		
	public function username_check($str){
		if(!isset($_POST["usuario_id"])){
			if ($this->M_usuarios->numeroLinhasTotais('', array('username'=>$_POST["username"])) > 0){
				$this->form_validation->set_message('username_check', 'Este usuário já está em uso.');
				return FALSE;
			}else{
				return TRUE;
			}
		}
	}

	
		function excluir($id=""){
			if ($id==""){
	
				if(isset($_POST["item"])) {
					$this->M_usuarios->setUsuarioId($_POST["item"]);	
					$this->M_usuarios->excluir();
				}
			}
			else{
				$this->M_usuarios->setUsuarioId($id);	
				$this->M_usuarios->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar($valor = "") {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_usuarios->selecionar($_POST["item"]);
			} else if ($valor != "") {
				$this->dados["registro"] = $this->M_usuarios->selecionar($valor);
			}
			$this->cadastro();
		}


}
?>