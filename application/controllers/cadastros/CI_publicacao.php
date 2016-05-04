<?php
class CI_publicacao extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_servidorborda');
		$this->load->model('M_sensor');
		$this->load->model('M_publicacao');
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
		$this->dados["linhas"] = $this->M_publicacao->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_publicacao->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Publicações Cadastradas";
		$pag['base_url'] = base_url."index.php/".$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
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
		$this->dados["sensores"] = $this->M_sensor->pesquisar('', array(), $nr_pagina="", $this->uri->segment(5));
		$this->dados["servidorbordas"] = $this->M_servidorborda->pesquisar('', array(), $nr_pagina="", $this->uri->segment(5));
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/publicacao/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('publicacao_servidorborda', 'Descrição', 'trim|required');
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
			$this->M_publicacao->setPublicacaoId($_POST["publicacao_id"]);
			$this->M_publicacao->setPublicacaoservidorborda($_POST["publicacao_servidorborda"]);
			$this->M_publicacao->setPublicacaoSensor($_POST["publicacao_sensor"]);
			$this->M_publicacao->setPublicacaoDataColeta($_POST["publicacao_datacoleta"]);
			$this->M_publicacao->setPublicacaoDataPublicacao($_POST["publicacao_datapublicacao"]);
			$this->M_publicacao->setPublicacaoValorColetado($_POST["publicacao_valorcoletado"]);
			if ($this->M_publicacao->salvar() == "inc"){
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
		$this->M_publicacao->setPublicacaoId("");
		$this->M_publicacao->setPublicacaoservidorborda($_POST["publicacao_servidorborda"]);
		$this->M_publicacao->setPublicacaoSensor($_POST["publicacao_sensor"]);
		$this->M_publicacao->setPublicacaoDataColeta($_POST["publicacao_datacoleta"]);
		$this->M_publicacao->setPublicacaoDataPublicacao($_POST["publicacao_datapublicacao"]);
		$this->M_publicacao->setPublicacaoValorColetado($_POST["publicacao_valorcoletado"]);
		$this->M_publicacao->salvaPublicacao();
	}
	
		function excluir($id=""){
			if ($id==""){
	
				if(isset($_POST["item"])) {
					$this->M_publicacao->setPublicacaoId($_POST["item"]);	
					$this->M_publicacao->excluir();
				}
			}
			else{
				$this->M_publicacao->setSensorId($id);	
				$this->M_publicacao->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar($valor = "") {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_publicacao->selecionar($_POST["item"]);
			} else if ($valor != "") {
				$this->dados["registro"] = $this->M_publicacao->selecionar($valor);
			}
			$this->cadastro();
		}

}
?>