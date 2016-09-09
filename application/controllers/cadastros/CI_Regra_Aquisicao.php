<?php

class CI_regra_Aquisicao extends CI_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_regras');
		$this->load->model('M_Regras_SB');
		$this->load->model('M_relcontextointeresse');
		$this->load->model('M_usuario');
		$this->load->model('M_contextointeresse');
		$this->load->model('M_sensor');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
			$this->dados['isLoged'] = true;
			$this->dados['usuario_logado'] = $this->session->userdata('nome');
		}else
			$this->dados['isLoged'] = false;
		$this->dados['title'] = "Gerenciador de Servidor de Contexto";
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{
		$this->pesquisa();
	}

	function select(){
		$registros = $this->M_regras->pesquisar()->result_array();

	    echo json_encode($registros);
	}

	function pesquisa($nr_pagina=20 ){
		$this->dados["metodo"] = "pesquisa";

		if ($this->session->userdata('perfilusuario_id') == 2) // É um superuser?
			$this->dados["linhas"]       = $this->M_regras->pesquisar('', array(), $nr_pagina, $this->uri->segment(5), 'asc', FALSE,2);
		else
			$this->dados["linhas"]       = $this->M_regras->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE,2);

		$this->dados["nr_pagina"]      = $nr_pagina;
		$this->dados["total"]          = $this->M_regras->numeroLinhasTotais('',array('tipo'=>2));
		$this->dados["tituloPesquisa"] = "Regras Cadastradas";
		$pag['base_url']               = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows']             = $this->dados["total"];
		$pag['uri_segment']	           = 5;
		$pag['per_page']               = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag);
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/regras_sb/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro(){
		$this->dados["regras"] = $this->M_regras->pesquisar();
		if ($this->session->userdata('perfilusuario_id') == 2){
			$this->dados["contextointeresse"] = $this->M_contextointeresse->pesquisar($select='', $where=array(), $limit=100, $offset=0, $ordem='asc');
			$this->dados["sensores"] = $this->M_sensor->pesquisar_livre();
		}
		else{
			$this->dados["contextointeresse"] = $this->M_contextointeresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);
			$this->dados["sensores"] = $this->M_sensor->pesquisar_livre();
}

		$this->load->view('inc/menu');
		$this->load->view('inc/topo',$this->dados);
		// $this->load->view('cadastros/regras/cadastro');
		$this->load->view('cadastros/regras_sb/cadastro');
		$this->load->view('inc/rodape');
	}
	function gravar(){

		if(isset($_POST["id_rule"])and $_POST["id_rule"] != ""){
			print_r("<br>Regra</br>");
			$this->M_Regras_SB->setRegraId($_POST["id_rule"]);
		}
		$get_test  = array('sensor' => $_POST["id_sensor"],
	  'jsonRule' => $_POST["rule"],
	 	'status' => $_POST["status"]);
	 	$data_string = json_encode($get_test,JSON_FORCE_OBJECT);

		$url = "http://10.0.1.106:8000/rules/";
		// $ch = curl_init($url);
		// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 	 	'Authorization: token 9517048ac92b9f9b5c7857e988580a66ba5d5061',
    // 		'Content-Type: application/json',
    // 	'Content-Length: ' . strlen($data_string))
		// );
		// $result = curl_exec($ch);
		// curl_close($ch);
		$name = $this->session->userdata('nome');
		// print_r($_POST["name_rule"],$_POST["status"],$_POST["rule"],$_POST["tipo"],$_POST["id_sensor"]);
		$this->M_Regras_SB->setRegraNome($_POST["id_sensor"]."".$name);
		$this->M_Regras_SB->setRegraStatus($_POST["status"]);
		$this->M_Regras_SB->setRegraArquivoPy($_POST["rule"]);
		$this->M_Regras_SB->setRegraTipo(2);
		$this->M_Regras_SB->setSensor(intval($_POST["id_sensor"]));
		if ($this->M_Regras_SB->salvar() == "inc"){
			$this->dados["msg"] = "Dados registrados com sucesso!";
			$this->pesquisa();
		}
		else{
		$this->dados["msg"] = "Dados alterados com sucesso!";
		$this->pesquisa();
	}
		// echo json_encode($get_test,JSON_FORCE_OBJECT);


	}

	function excluir($id=""){
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_regras->setRegraId($_POST["item"]);
				$this->M_regras->excluir();
			}
		}
		else{
			$this->M_regras->setRegraId($id);
			$this->M_regras->excluir();
		}
		$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		$this->pesquisa();
	}

   function editar($valor = "") {

		if(isset($_POST["item"])) {

			$this->dados["registro"] = $this->M_regras->selecionar($_POST["item"]);
			$this->dados["editable"] = "true";
			$registro = $this->dados["registro"]->result_array();
		// print "<pre>";
		// print_r($this->M_Regras_SB);
		// print "</pre>";
		// print "<pre>";
		// print_r($registro[0]);
		// print "</pre>";
			$this->dados["sensor"]   = $this->M_Regras_SB->get_sensor($registro[0]['regra_id']);
	} else if ($valor != "") {
			$this->dados["registro"] = $this->M_regras->selecionar($valor);
			$this->dados["editable"] = "true";
			$registro = $this->dados["registro"]->result_array();
			$this->dados["sensor"]   = $this->M_Regras_SB->get_sensor($registro[0]['regra_id']);
	}
		$this->cadastro();
	}

	function ativar($id="") {
		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_regras->setRegraId($_POST["item"]);
				$this->M_regras->setRegraStatus('true');
				$this->M_regras->altStatus();
			}
		}
		else{
			$this->M_regras->setRegraId($id);
			$this->M_regras->setRegraStatus('true');
			$this->M_regras->altStatus();
		}
		$this->dados["msg"] = "Regra ativada com sucesso!";
		$this->pesquisa();
	}

	function desativar($id="") {

		if ($id==""){

			if(isset($_POST["item"])) {
				$this->M_regras->setRegraId($_POST["item"]);
				$this->M_regras->setRegraStatus('false');
				$this->M_regras->altStatus();
			}
		}
		else{
			$this->M_regras->setRegraId($id);
			$this->M_regras->setRegraStatus('false');
			$this->M_regras->altStatus();
		}
		$this->dados["msg"] = "Regra desativada com sucesso!";
		$this->pesquisa();
	}

	function getSensorByRci($id=""){
		if ($id==""){
			if(isset($_POST["contextointeresse"])) {
				$sensores = $this->M_relcontextointeresse->getByCi($_POST["contextointeresse"]);
			}
		}else{
			$sensores = $this->M_relcontextointeresse->getByCi($id);
		}

	    echo json_encode($sensores);
	}

}

?>
