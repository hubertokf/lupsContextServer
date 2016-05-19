<?php
class CI_perfil extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_perfil');
		$this->load->model('M_usuario');
		$this->load->model('M_menu');
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
		$this->dados["linhas"] = $this->M_perfil->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_perfil->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Perfils Cadastrados";
		$pag['base_url'] = base_url."index.php/".$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
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
		$this->dados["menus"] = $this->M_menu->pesquisarParentes();
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
			$this->M_perfil->setPerfilId($_POST["perfilusuario_id"]);
			$this->M_perfil->setPerfilDesc($_POST["perfilusuario_desc"]);
			$this->M_perfil->setPerfilNome($_POST["perfilusuario_nome"]);
			if ($this->M_perfil->salvar() == "inc"){
				$this->M_perfil->setPerfilId($this->db->insert_id());
				if (isset($_POST['perfilusuario_menu'])){
					$this->M_perfil->excluirMenus();
					foreach ($_POST['perfilusuario_menu'] as $key => $value) {
						$this->M_perfil->salvarMenu($value);
					}
				}	
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				if (isset($_POST['perfilusuario_menu'])){
					$this->M_perfil->excluirMenus();
					foreach ($_POST['perfilusuario_menu'] as $key => $value) {
						$this->M_perfil->salvarMenu($value);
					}
				}	
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}	
	}
	
	function excluir($id=""){
		if ($id==""){
			if(isset($_POST["item"])) {
				$this->M_perfil->setPerfilId($_POST["item"]);	
				$this->M_perfil->excluir();
			}
		}
		else{
			$this->M_perfil->setPerfilId($id);	
			$this->M_perfil->excluir();
		}
		$this->M_perfil->excluirMenus();
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_perfil->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_perfil->selecionar($valor);			
		}
		$this->cadastro();
	}


}
?>