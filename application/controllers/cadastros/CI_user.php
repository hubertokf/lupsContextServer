<?php
class CI_user extends CI_controller {

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
		$this->load->model('M_user');
		$this->load->model('M_usuario');
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
		$this->dados["linhas"] = $this->M_user->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_user->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Usuários Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/user/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/user/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->M_user->setUserId($_POST["user_id"]);
		$this->M_user->setUserUsername($_POST["user_username"]);
		$this->M_user->setUserPasswd($_POST["user_passwd"]);
		$this->M_user->setUserMail($_POST["user_mail"]);
		if ($this->M_user->salvar() == "inc"){
			$this->dados["msg"] = "Dados registrados com sucesso!";
			$this->pesquisa();	
		}
		else {
			$this->dados["msg"] = "Dados alterados com sucesso!";
			$this->pesquisa();	
		}
	}
	
		function excluir($id=""){
			if ($id==""){
	
				if(isset($_POST["item"])) {
					$this->M_agenda->setAgendamentoId($_POST["item"]);	
					$this->M_agenda->excluir();
				}
			}
			else{
				$this->M_agenda->setAgendamentoId($id);	
				$this->M_agenda->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar() {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_agenda->selecionar($_POST["item"]);
			}
			$this->cadastro();
		}


}
?>