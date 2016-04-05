<?php
class CI_permissoes extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_permissoes');
		$this->load->model('M_usuario');
		$this->load->model('M_contextointeresse');
		$this->load->model('M_sensor');
		$this->load->model('M_ambiente');
		$this->load->model('M_regras');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
			$this->dados['isLoged'] = true;
			$this->dados['usuario_logado'] = $this->session->userdata('nome');
		}else
			$this->dados['isLoged'] = false;
		$this->dados['title'] = "Gerenciador de permissões";
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}
	
	function editar($nr_pagina=10, $user_id=""){
		$where = array();
		if ($user_id != "")
			$this->dados["perm_user"] = $user_id;
		else
			if ($this->input->post('item') != FALSE){
				$where = array('permissoes.usuario_id'=>$this->input->post('item'));
				$this->dados["perm_user"] = $this->input->post('item');
			}
		$user_name = $this->M_usuario->selecionar($this->dados["perm_user"])->result_array()[0]["nome"];
		$this->dados["perfil_user"] = $this->M_usuario->selecionar($this->dados["perm_user"])->result_array()[0]["perfilusuario_id"];
		$this->dados["metodo"] = "pesquisa";
		$this->dados["linhas"] = $this->M_permissoes->pesquisar('',$where, $nr_pagina, $this->uri->segment(5), 'permissao_id', $ordem='asc');
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_permissoes->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Permissões cadastradas para o usuário '".$user_name."'";
		$pag['base_url'] = base_url."index.php/".$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/permissoes/pesquisa');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('permissao_usuario', 'Usuario', 'trim|required');
		$this->form_validation->set_rules('perm_tipo', 'Tipo', 'trim|required');
		$this->form_validation->set_rules('perm_registro', 'Registro', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			$this->editar(10, $_POST['permissao_usuario']);
		}
		else
		{
			$this->M_permissoes->setPermissaoUsuario($_POST["permissao_usuario"]);
			$this->M_permissoes->setPermissaoPodeeditar(isset($_POST["canEdit"]) ? $_POST["canEdit"] : FALSE);
			$this->M_permissoes->setPermissaoRecebeemail(isset($_POST["rcvEmail"]) ? $_POST["rcvEmail"] : FALSE);
			switch ($this->input->post('perm_tipo')) {
			    case "1":
					$this->M_permissoes->setPermissaoAmbiente($_POST["perm_registro"]);				
			        break;
			    case "2":
					$this->M_permissoes->setPermissaoContextoInteresse($_POST["perm_registro"]);
			        break;
			    case "3":
					$this->M_permissoes->setPermissaoRegra($_POST["perm_registro"]);
			        break;
			    case "4":
					$this->M_permissoes->setPermissaoSensor($_POST["perm_registro"]);
			        break;
			}
			if ($this->M_permissoes->salvar() == "inc"){
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->editar(10, $_POST['permissao_usuario']);
			}
			else {
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->editar(10, $_POST['permissao_usuario']);
			}
		}
	}
	
	function excluir($id=""){
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_permissoes->setPermissaoId($_POST["item"]);	
				$this->M_permissoes->excluir();
			}
		}
		else{
			$this->M_permissoes->setPermissaoId($id);	
			$this->M_permissoes->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->editar(10, $_POST['permissao_usuario']);
	}
}
?>