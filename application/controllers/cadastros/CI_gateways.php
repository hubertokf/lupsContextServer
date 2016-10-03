<?php
class CI_gateways extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_gateways');
		$this->load->model('M_servidoresborda');
		$this->load->model('M_fabricantes');
		$this->load->model('M_usuarios');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
			$this->dados['isLoged'] = true;
			$this->dados['usuario_logado'] = $this->session->userdata('nome');
		}else
			$this->dados['isLoged'] = false;
		$this->dados['title'] = "Gerenciador de Gateways";
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{	
		$this->pesquisa();
	}
	
	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";
		$this->dados["linhas"] = $this->M_gateways->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_gateways->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Gateways Cadastrados";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag); 
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/gateway/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["fabricantes"] = $this->M_fabricantes->pesquisar();
		$this->dados["servidorbordas"] = $this->M_servidoresborda->pesquisar();
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/gateway/cadastro');
		$this->load->view('inc/rodape');
	}
	
	function gravar(){
		$this->form_validation->set_rules('gateway_nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('gateway_servidorborda', 'Servidor de Borda', 'trim|required');
		$this->form_validation->set_rules('gateway_status', 'Status', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			if ($_POST['gateway_id'] != "") {
				$this->editar($_POST['gateway_id']);
			} else {
				$this->cadastro();
			}
			
		} else {
			$this->M_gateways->setGatewayId($_POST["gateway_id"]);
			$this->M_gateways->setGatewayNome($_POST["gateway_nome"]);
			$this->M_gateways->setGatewayModelo($_POST["gateway_modelo"]);
			$this->M_gateways->setGatewayFabricante($_POST["gateway_fabricante"]);
			$this->M_gateways->setGatewayservidorborda($_POST["gateway_servidorborda"]);
			$this->M_gateways->setGatewayStatus($_POST["gateway_status"]);
			if ($this->M_gateways->salvar() == "inc"){
				$this->dados["msg"] = "Dados registrados com sucesso!";
				$this->pesquisa();	
			}
			else {
				$this->dados["msg"] = "Dados alterados com sucesso!";
				$this->pesquisa();	
			}
		}
	}

	function gravaGateway(){
		$this->M_gateways->setGatewayId("");
		$this->M_gateways->setGatewayNome($_POST["gateway_nome"]);
		$this->M_gateways->setGatewayservidorborda($_POST["gateway_servidorborda"]);
		$this->M_gateways->setGatewayUID($_POST["gateway_uid"]);
		$gatewayID = $this->M_gateways->salvaGateway();

		echo $gatewayID;
	}

	function teste(){
		$this->M_gateways->setGatewayNome("Gateway LUPS");
		$this->M_gateways->setGatewayservidorborda("9");
		$this->M_gateways->setGatewayUID("uuid:35c0c38e-4516-b17d-ffff-ffffb9805b38");
		$gatewayID = $this->M_gateways->salvaGateway();

		echo $gatewayID;
	}
	
	function excluir($id=""){
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_gateways->setGatewayId($_POST["item"]);	
				$this->M_gateways->excluir();
			}
		}
		else{
			$this->M_gateways->setGatewayId($id);	
			$this->M_gateways->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {
		if(isset($_POST["item"])) {
			$this->dados["registro"] = $this->M_gateways->selecionar($_POST["item"]);
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_gateways->selecionar($valor);
		}	
		$this->cadastro();
	}

	function getGatewaysBySBID($id=""){
		if ($id==""){	
			if(isset($_POST["servidorborda"])) {
				$gateways = $this->M_gateways->getBySBid($_POST["servidorborda"]);
			}
		}else{
			$gateways = $this->M_gateways->getBySBid($id);
		}

	    echo json_encode($gateways);
	}

	function toggleGateway(){
		if(isset($_POST["job"])){
			$job = $_POST["job"];
			if($job == "deactivate"){
				$this->desativar($_POST["gateway_id"], true);

				echo "desativado";
			}else if($job == "activate"){
				$this->ativar($_POST["gateway_id"], true);

				echo "ativado";
			}
		}
	}

	function ativar($id="", $silent = false) {
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_gateways->setGatewayId($_POST["item"]);	
				$this->M_gateways->setGatewayStatus('true');	
				$this->M_gateways->altStatus();
			}
		}
		else{
			$this->M_gateways->setGatewayId($id);	
			$this->M_gateways->setGatewayStatus('true');	
			$this->M_gateways->altStatus();
		}

		if($silent != true){
			$this->dados["msg"] = "Gateway ativado com sucesso!";
			$this->pesquisa();
		}
	}

	function desativar($id="", $silent = false) {

		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_gateways->setGatewayId($_POST["item"]);
				$this->M_gateways->setGatewayStatus('false');
				$this->M_gateways->altStatus();
			}
		}
		else{
			$this->M_gateways->setGatewayId($id);	
			$this->M_gateways->setGatewayStatus('false');	
			$this->M_gateways->altStatus();
		}

		if($silent != true){
			$this->dados["msg"] = "Gateway desativado com sucesso!";
			$this->pesquisa();
		}
	}

}
?>