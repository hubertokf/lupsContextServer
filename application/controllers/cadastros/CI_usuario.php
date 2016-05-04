<?php
class CI_usuario extends CI_controller {

	public function __construct()
	{
		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		    die();
		}
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_usuario');
		$this->load->model('M_perfil');
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
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";
		$this->dados["linhas"] = $this->M_usuario->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_usuario->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Usuários Cadastrados";
		$pag['base_url'] = base_url."index.php/".$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
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
		$this->dados["perfis"] = $this->M_perfil->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/usuario/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('usuario_perfil', 'Perfil', 'trim|required');
		$this->form_validation->set_rules('usuario_nome', 'Nome', 'trim|required|callback_username_check');
		$this->form_validation->set_rules('usuario_username', 'Username', 'trim|required');
		$this->form_validation->set_rules('usuario_password', 'Password', 'trim|required');
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
			$this->M_usuario->setUsuarioId($_POST["usuario_id"]);
			$this->M_usuario->setUsuarioPerfil($_POST["usuario_perfil"]);
			$this->M_usuario->setUsuarioNome($_POST["usuario_nome"]);
			$this->M_usuario->setUsuarioUsername($_POST["usuario_username"]);
			$this->M_usuario->setUsuarioPassword($_POST["usuario_password"]);
			$this->M_usuario->setUsuarioEmail($_POST["usuario_email"]);
			$this->M_usuario->setUsuarioTelefone($_POST["usuario_telefone"]);
			$this->M_usuario->setUsuarioCelular($_POST["usuario_celular"]);
			if ($this->M_usuario->salvar() == "inc"){
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
			if ($this->M_usuario->numeroLinhasTotais('', array('username'=>$_POST["username"])) > 0){
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
					$this->M_usuario->setUsuarioId($_POST["item"]);	
					$this->M_usuario->excluir();
				}
			}
			else{
				$this->M_usuario->setUsuarioId($id);	
				$this->M_usuario->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar($valor = "") {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_usuario->selecionar($_POST["item"]);
			} else if ($valor != "") {
				$this->dados["registro"] = $this->M_usuario->selecionar($valor);
			}
			$this->cadastro();
		}


}
?>