<?php

class CI_regras_agendamento extends CI_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_regras');
		$this->load->model('M_Regras_SB');
		$this->load->model('M_relcontextointeresse');
		$this->load->model('M_usuarios');
		$this->load->model('M_contextosinteresse');
		$this->load->model('M_sensores');
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
			$this->dados["contextointeresse"] = $this->M_contextosinteresse->pesquisar($select='', $where=array(), $limit=100, $offset=0, $ordem='asc');
			$this->dados["sensores"] = $this->M_sensores->pesquisar();
		}
		else{
			$this->dados["contextointeresse"] = $this->M_contextosinteresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);
			$this->dados["sensores"] = $this->M_sensores->pesquisar();
		}

		if(!isset($this->dados["editable"])){
			$this->dados["editable"] = "false";
		}

		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		// $this->load->view('cadastros/regras/cadastro');
		$this->load->view('cadastros/regras_sb/cadastro');
		$this->load->view('inc/rodape');
	}
	function gravar(){
		$json = json_encode($_POST["rule"]);
		$get_test  = array('sensor' => $_POST["id_sensor"],
		''=> $json,
		'status' => $_POST["status"]);

		if(isset($_POST["id_rule"])and $_POST["id_rule"] != ""){ // se id estiver setado, é uma edição
				$id_rule_edge = $this->distributed_rule($_POST["id_rule"],$_POST["id_sensor"],$get_test); //metodo para enviar regra ao servidor de borda
				$this->M_Regras_SB->setRegraId($_POST["id_rule"]);

				if($id_rule_edge == null){ //se for null, possível perda de comunicação ou problema no servidor de borda
					$id_rule_edge_off = $this->M_Regras_SB->getRegraIdBorda($_POST["id_rule"]); //seta a variavel com um valor já existente
					$this->M_Regras_SB->setRegraIdBorda($id_rule_edge_off);
				}
		}
		else{
			$id_rule_edge = $this->distributed_rule('',$_POST["id_sensor"],$get_test);
			$this->M_Regras_SB->setRegraIdBorda($id_rule_edge);
		}

		$this->M_Regras_SB->setRegraNome($_POST["rules_name"]);
		$this->M_Regras_SB->setRegraStatus($_POST["status"]);
		$this->M_Regras_SB->setRegraArquivoPy($_POST["rule"]);
		$this->M_Regras_SB->setRegraTipo(4);
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
	function get_rules(){
		if(isset($_POST["sensor_id"])){
			$response = $this->M_regras->selecionar($_POST["sensor_id"])->result_array();
			$response = $response[0]['arquivo_py'];
		}
		else{
			$response = "algo de errado";
		}

		echo json_encode($response);
	}

	public function distributed_rule($id_regra_context='',$id_sensor='',$array=array()){

		$request         = "POST";
		$get_url         = $this->M_sensor->get_acesso_borda(array('sensor_id' =>$id_sensor))->result_array();
		$url             = $get_url[0]["url"];
		$token           = $get_url[0]["token"];
		$id_sensor_borda = $this->M_sensor->get_borda_id($id_sensor);
		$array           = array_merge($array,array('sensor'=>$id_sensor_borda));
		$url_rule        = $url."rules/";

		if($id_regra_context != ''){

			$request           = "PUT";
			$array["id_regra"] = $this->M_Regras_SB->getRegraIdBorda($id_regra_context);
			$url_rule          = $url_rule.$array["id_regra"]."/"; // concatenar com id_regra_borda
			$ch                = curl_init($url_rule);
			$data_string       = json_encode($array,JSON_FORCE_OBJECT);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		}
		else{

			$ch          = curl_init($url_rule);
			$data_string = json_encode($array,JSON_FORCE_OBJECT);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		}
		// print_r($url_rule);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: token '.$token,
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
		);
		$result = curl_exec($ch);
		// print_r(json_decode($result));
		curl_close($ch);
		return json_decode($result)->id;
	}

	function get_rules_names(){

		if(isset($_POST["id_sensor"])){
			$response = $this->M_Regras_SB->get_rules($_POST["id_sensor"])->result_array();
		}
		else{
			$response = "algo de errado";
		}

		echo json_encode($response);
	}

	function excluir($id=""){
		if ($id==""){
			$id_regra_contexto = $_POST["item"];
			if(isset($_POST["item"])) {
				$this->M_regras->setRegraId($_POST["item"]);
				$this->M_regras->excluir();
			}
		}
		else{
			$id_regra_contexto = $id;
			$this->M_regras->setRegraId($id);
			$this->M_regras->excluir();
		}
		$id_regra_borda    = $this->M_Regras_SB->getRegraIdBorda($id_regra_contexto);
		$id_sensor         = $this->M_regras_SB->selecionar($id_regra_context)->result_array();
		$get_url           = $this->M_sensor->get_acesso_borda(array('sensor_id' =>$id_sensor[0]["sensor_id"]))->result_array();
		$url               = $get_url[0]["url"];
		$token             = $get_url[0]["token"];
		$url_rule          = $url."rules/".$id_regra_borda."/";
		$ch                = curl_init($url_rule);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: token '.$token,
				'Content-Type: application/json')
		);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result == null){
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
		}
		else{
			$this->dados["msg"] = "Não foi possível excluir registro na borda, tentativa será realizada automaticamente!";
		}
		echo $this->dados["msg"];

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
			$this->dados["sensor"]   = $this->M_Regras_SB->get_sensor_id($registro[0]['regra_id']);
	} else if ($valor != "") {
			$this->dados["registro"] = $this->M_regras->selecionar($valor);
			$this->dados["editable"] = "true";
			$registro = $this->dados["registro"]->result_array();
			$this->dados["sensor"]   = $this->M_Regras_SB->get_sensor_id($registro[0]['regra_id']);
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
