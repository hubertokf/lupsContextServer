<?php
class CI_configuracoes extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
		$this->load->library('upload');
		$this->load->library('image_lib');
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
		$this->cadastro();
	}
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";
		$this->dados["linhas"] = $this->M_configuracoes->pesquisar();
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_configuracoes->numeroLinhasTotais($select='', $where=array());
		$this->dados["tituloPesquisa"] = "Configurações do Perfil";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/configuracoes/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["linhas"] = $this->M_configuracoes->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/configuracoes/cadastro');
		$this->load->view('inc/rodape');
	}

	function removeImage($nome_exc){
		if(isset($nome_exc))
			unlink("./uploads/".$nome_exc);
	}
	
	function removeImageByConfig($id="",$nome_exc){
		$excluir = $this->M_configuracoes->selecionar($id)->result_array();
		if(isset($excluir[0][$nome_exc]))
			unlink("./uploads/".$excluir[0][$nome_exc]);
	}

	function gravar(){
		$this->form_validation->set_rules('titulo_projeto', 'Titulo do Projeto', 'trim|required');
		$this->form_validation->set_rules('titulo', 'Titulo da Aplicacao', 'trim|required');
		$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
				$this->cadastro();
		} else {
			$imgCabecalho = $this->M_geral->uploadFile("img_cabecalho",true);

			if (isset($imgCabecalho["upload_data"])){
				$_POST['img_cabecalho'] = $imgCabecalho["upload_data"]['file_name'];
			}
			
			$imgProjeto = $this->M_geral->uploadFile("img_projeto",true);
			if (isset($imgProjeto["upload_data"])){
				$_POST['img_projeto'] = $imgProjeto["upload_data"]['file_name'];
			}

			foreach ($_POST as $key => $value) {

				$this->M_configuracoes->setName($key);
				$this->M_configuracoes->setValue(isset($value) ? $value : null);

				if($this->M_configuracoes->salvar() == "alt")
					$this->dados["msg"] = "Dados registrados com sucesso!";
				else
					$this->dados["msg"] = "Dados não registrados com sucesso!";
			}
			
			$this->cadastro();
		}
	}

	function gravarGeral(){
		$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			if ($_POST['configuracao_id'] != "") {
				$this->editar($_POST['configuracao_id']);	
			} else {	
				$this->cadastro();
			}			
		} else {

			$this->M_configuracoes->setConfiguracaoId(1);
			$this->M_configuracoes->setUsuarioId(null);
			$this->M_configuracoes->setTitulo($_POST["titulo"]);
			
			$imgCabecalho = $this->M_geral->uploadFile("img_cabecalho");
			$old = $this->M_configuracoes->selecionar(1)->result_array();
			if (isset($imgCabecalho["upload_data"])){
					if (isset($old[0]["img_cabecalho"]) && $old[0]["img_cabecalho"] != null){
						$this->removeImageByConfig($this->session->userdata('usuario_id'),"img_cabecalho");
					}
					$this->M_configuracoes->setImgCabecalho($imgCabecalho["upload_data"]['file_name']);
			}
			else
				$this->M_configuracoes->setImgCabecalho($old[0]["img_cabecalho"]);

			$imgProjeto = $this->M_geral->uploadFile("img_projeto");
			$old = $this->M_configuracoes->selecionar(1)->result_array();
			if (isset($imgProjeto["upload_data"])){
					if (isset($old[0]["img_projeto"]) && $old[0]["img_projeto"] != null){
						$this->removeImageByConfig($this->session->userdata('usuario_id'),"img_projeto");
					}
					$this->M_configuracoes->setImgProjeto($imgProjeto["upload_data"]['file_name']);
			}
			else
				$this->M_configuracoes->setImgProjeto($old[0]["img_projeto"]);
			
			$this->M_configuracoes->setCorPredominante(isset($_POST["cor_predominante"]) ? $_POST["cor_predominante"] : null);
			
			$this->M_configuracoes->salvar();
			$this->dados["msg"] = "Dados alterados com sucesso!";
			$this->geral();
		}
	}
	
	function excluir($id=""){
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->removeImageByConfig($_POST["item"],"img_projeto");
				$this->removeImageByConfig($_POST["item"],"img_cabecalho");
				$this->M_configuracoes->setConfiguracaoId($_POST["item"]);	
				$this->M_configuracoes->excluir();
			}
		}
		else{
			$this->removeImageByConfig($id,"img_projeto");
			$this->removeImageByConfig($id,"img_cabecalho");
			$this->M_configuracoes->setConfiguracaoId($id);	
			$this->M_configuracoes->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_configuracoes->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_configuracoes->selecionar($valor);
		}
		$this->cadastro();
	}

}
?>
