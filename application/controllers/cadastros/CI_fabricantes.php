<?php
	class CI_fabricantes extends CI_controller {
	
		public function __construct(){
			parent::__construct();
			
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
			$this->load->model('M_fabricantes');
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
			$this->dados["linhas"] = $this->M_fabricantes->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
			$this->dados["nr_pagina"] = $nr_pagina;
			$this->dados["total"] = $this->M_fabricantes->numeroLinhasTotais();
			$this->dados["tituloPesquisa"] = "Fabricantes Cadastrados";
			$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
			$pag['total_rows'] = $this->dados["total"];
			$pag['uri_segment']	= 5;
			$pag['per_page'] = $this->dados["nr_pagina"];
			$this->pagination->initialize($pag); 
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('inc/topoPesquisa');
			$this->load->view('cadastros/fabricante/pesquisa');
			$this->load->view('inc/rodape');
		}
	
		function cadastro(){
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('cadastros/fabricante/cadastro');
			$this->load->view('inc/rodape');
		}
		
		function gravar(){
			$this->form_validation->set_rules('fabricante_nome', 'Nome', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
			$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
			if ($this->form_validation->run() == FALSE)
			{
				if ($_POST['fabricante_id'] != "") {
					$this->editar($_POST['fabricante_id']);	
				} else {	
					$this->cadastro();
				}
			} else 	{
				$this->M_fabricantes->setFabricanteId($_POST["fabricante_id"]);
				$this->M_fabricantes->setFabricanteNome($_POST["fabricante_nome"]);
				$this->M_fabricantes->setFabricanteEndereco($_POST["fabricante_endereco"]);
				$this->M_fabricantes->setFabricanteTelefone($_POST["fabricante_telefone"]);
				$this->M_fabricantes->setFabricanteUrl($_POST["fabricante_url"]);
				$this->M_fabricantes->setFabricanteCidade($_POST["fabricante_cidade"]);
				$this->M_fabricantes->setFabricanteEstado($_POST["fabricante_estado"]);
				$this->M_fabricantes->setFabricantePais($_POST["fabricante_pais"]);
				if ($this->M_fabricantes->salvar() == "inc"){
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
					$this->M_fabricantes->setFabricanteId($_POST["item"]);	
					$this->M_fabricantes->excluir();
				}
			}
			else{
				$this->M_fabricantes->setFabricanteId($id);	
				$this->M_fabricantes->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar($valor = "") {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_fabricantes->selecionar($_POST["item"]);
			} else if ($valor != "") {
				$this->dados["registro"] = $this->M_fabricantes->selecionar($valor);
				
			}
			$this->cadastro();
		}

	}
?>