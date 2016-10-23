<?php
class CI_perfisusuarios extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_perfisusuarios');
		$this->load->model('M_usuarios');
		$this->load->model('M_menus');
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
		$this->dados["linhas"] = $this->M_perfisusuarios->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_perfisusuarios->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Perfils Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/perfil/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["menus"] = $this->M_menus->pesquisarParentes();
		$perfilusuario_id = $this->session->userdata('perfilusuario_id');
		$this->dados["isAdm"] = $this->M_perfisusuarios->isAdm($perfilusuario_id);
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/perfil/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('perfilusuario_nome', 'Nome', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['perfil_id'] != "") {
				$this->editar($_POST['perfil_id']);
			} else {
				$this->cadastro();
			}
		} else	{
			$this->M_perfisusuarios->setPerfilId($_POST["perfilusuario_id"]);
			$this->M_perfisusuarios->setPerfilDesc($_POST["perfilusuario_desc"]);
			$this->M_perfisusuarios->setPerfilNome($_POST["perfilusuario_nome"]);
			$this->M_perfisusuarios->setPerfilSuperAdm(isset($_POST["perfilusuario_superAdm"]) ? $_POST["perfilusuario_superAdm"] : false);
			if ($this->M_perfisusuarios->salvar() == "inc"){
				$this->M_perfisusuarios->setPerfilId($this->db->insert_id());
				if(!isset($_POST["perfilusuario_superAdm"])){
					if (isset($_POST['perfilusuario_menu'])){
						$this->M_perfisusuarios->excluirMenus();
						foreach ($_POST['perfilusuario_menu'] as $key => $value) {
							$this->M_perfisusuarios->salvarMenu($value);
						}
					}	
				}else{
					$this->M_perfisusuarios->excluirMenus();
				}
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				if(!isset($_POST["perfilusuario_superAdm"])){				
					if (isset($_POST['perfilusuario_menu'])){
						$this->M_perfisusuarios->excluirMenus();
						foreach ($_POST['perfilusuario_menu'] as $key => $value) {
							$this->M_perfisusuarios->salvarMenu($value);
						}
					}
				}else{
					$this->M_perfisusuarios->excluirMenus();
				}
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}	
	}
	
	function excluir($id=""){
		if ($id==""){
			if(isset($_POST["item"])) {
				$this->M_perfisusuarios->setPerfilId($_POST["item"]);	
				$this->M_perfisusuarios->excluir();
			}
		}
		else{
			$this->M_perfisusuarios->setPerfilId($id);	
			$this->M_perfisusuarios->excluir();
		}
		$this->M_perfisusuarios->excluirMenus();
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_perfisusuarios->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_perfisusuarios->selecionar($valor);			
		}
		$this->cadastro();
	}


}
?>