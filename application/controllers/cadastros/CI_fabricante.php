<?php
	class CI_fabricante extends CI_controller {
	
		public function __construct(){
			parent::__construct();
			
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
			$this->load->model('M_fabricante');
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
		
		function pesquisa($nr_pagina=10){
			$this->dados["metodo"] = "pesquisa";
			$this->dados["linhas"] = $this->M_fabricante->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
			$this->dados["nr_pagina"] = $nr_pagina;
			$this->dados["total"] = $this->M_fabricante->numeroLinhasTotais();
			$this->dados["tituloPesquisa"] = "Fabricantes Cadastrados";
			$pag['base_url'] = base_url."index.php/".$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
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
				$this->M_fabricante->setFabricanteId($_POST["fabricante_id"]);
				$this->M_fabricante->setFabricanteNome($_POST["fabricante_nome"]);
				$this->M_fabricante->setFabricanteEndereco($_POST["fabricante_endereco"]);
				$this->M_fabricante->setFabricanteTelefone($_POST["fabricante_telefone"]);
				$this->M_fabricante->setFabricanteUrl($_POST["fabricante_url"]);
				$this->M_fabricante->setFabricanteCidade($_POST["fabricante_cidade"]);
				$this->M_fabricante->setFabricanteEstado($_POST["fabricante_estado"]);
				$this->M_fabricante->setFabricantePais($_POST["fabricante_pais"]);
				if ($this->M_fabricante->salvar() == "inc"){
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
					$this->M_fabricante->setFabricanteId($_POST["item"]);	
					$this->M_fabricante->excluir();
				}
			}
			else{
				$this->M_fabricante->setFabricanteId($id);	
				$this->M_fabricante->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar($valor = "") {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_fabricante->selecionar($_POST["item"]);
			} else if ($valor != "") {
				$this->dados["registro"] = $this->M_fabricante->selecionar($valor);
				
			}
			$this->cadastro();
		}

	}
?>