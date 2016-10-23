<?php
class CI_publicacoes extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_servidoresborda');
		$this->load->model('M_sensores');
		$this->load->model('M_publicacoes');
		$this->load->model('M_usuarios');
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
		$perfilusuario_id = $this->session->userdata('perfilusuario_id');
		$this->dados["isAdm"] = $this->M_perfisusuarios->isAdm($perfilusuario_id);
		if ($this->dados["isAdm"] == 't'){
			$this->dados["linhas"] = $this->M_publicacoes->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
			$this->dados["total"] = $this->M_publicacoes->numeroLinhasTotais();
		}else{
			$this->dados["linhas"] = $this->M_publicacoes->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'publicacao_id', 'asc', TRUE);
			$this->dados["total"] = $this->M_publicacoes->numeroLinhasTotais('',array("p.usuario_id"=>$this->session->userdata('usuario_id')), TRUE);
		}
		$this->dados["nr_pagina"] = $nr_pagina;

		$this->dados["tituloPesquisa"] = "Publicações Cadastradas";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/publicacao/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["sensores"] = $this->M_sensores->pesquisar('', array(), $nr_pagina="", $this->uri->segment(5));
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/publicacao/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('publicacao_sensor', 'Sensor', 'trim|required');
		$this->form_validation->set_rules('publicacao_datapublicacao', 'Data Publicação', 'trim|required');
		$this->form_validation->set_rules('publicacao_datacoleta', 'Data Coleta', 'trim|required');
		$this->form_validation->set_rules('publicacao_valorcoletado', 'Valor', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo %s!');
		if ($this->form_validation->run() == FALSE)
		{
			if ($_POST['publicacao_id'] != "") {
				$this->editar($_POST['publicacao_id']);	
			} else {	
				$this->cadastro();
			}
		} else	{
			$this->M_publicacoes->setPublicacaoId($_POST["publicacao_id"]);
			$this->M_publicacoes->setPublicacaoSensor($_POST["publicacao_sensor"]);
			$this->M_publicacoes->setPublicacaoDataColeta($_POST["publicacao_datacoleta"]);
			$this->M_publicacoes->setPublicacaoDataPublicacao($_POST["publicacao_datapublicacao"]);
			$this->M_publicacoes->setPublicacaoValorColetado($_POST["publicacao_valorcoletado"]);
			if ($this->M_publicacoes->salvar() == "inc"){
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}	
	}

	function gravaPublicacao(){
		$this->M_publicacoes->setPublicacaoId("");
		$this->M_publicacoes->setPublicacaoSensor($_POST["publicacao_sensor"]);
		$this->M_publicacoes->setPublicacaoDataColeta($_POST["publicacao_datacoleta"]);
		$this->M_publicacoes->setPublicacaoDataPublicacao($_POST["publicacao_datapublicacao"]);
		$this->M_publicacoes->setPublicacaoValorColetado($_POST["publicacao_valorcoletado"]);
		$this->M_publicacoes->salvaPublicacao();
	}
	
		function excluir($id=""){
			if ($id==""){
	
				if(isset($_POST["item"])) {
					$this->M_publicacoes->setPublicacaoId($_POST["item"]);	
					$this->M_publicacoes->excluir();
				}
			}
			else{
				$this->M_publicacoes->setSensorId($id);	
				$this->M_publicacoes->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar($valor = "") {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_publicacoes->selecionar($_POST["item"]);
			} else if ($valor != "") {
				$this->dados["registro"] = $this->M_publicacoes->selecionar($valor);
			}
			$this->cadastro();
		}

}
?>