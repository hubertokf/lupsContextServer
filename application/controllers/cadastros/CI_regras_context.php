<?php

class CI_regras_context extends CI_controller {
	 // faz a interoperação de regra entre o metodo editar com o sendInformation
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_regras');
		$this->load->model('M_relcontextointeresse');
		$this->load->model('M_usuarios');
		$this->load->model('M_contextosinteresse');
		$this->load->model('M_sensores');
		$this->load->model('M_Regras_SB');
		$this->load->model('M_conditions');
		$this->load->model('M_actions');
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
		if ($this->session->userdata('perfilusuario_id') == 2)
			$this->dados["linhas"] = $this->M_regras->pesquisar('', array('r.tipo !='=>2,'r.tipo !='=>4), $nr_pagina, $this->uri->segment(5), 'asc', FALSE,3);
		else
			$this->dados["linhas"] = $this->M_regras->pesquisar('', array('r.tipo !='=>2,'r.tipo !='=>4,'p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE,3);

		$this->dados["nr_pagina"]      = $nr_pagina;
		$this->dados["total"]          = $this->M_regras->numeroLinhasTotais('',array('tipo !='=>2,'tipo !='=>4));
		$this->dados["tituloPesquisa"] = "Regras Cadastradas";
		$pag['base_url']               = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows']             = $this->dados["total"];
		$pag['uri_segment']	           = 5;
		$pag['per_page']               = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag);
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/regras_cs/pesquisa');
		$this->load->view('inc/rodape');
	}

	function cadastro($value = ""){
		if ($this->session->userdata('perfilusuario_id') == 2){
			// $this->dados["sensores"] = $this->M_sensores->pesquisar($select='', $where=array(), $limit=100, $offset=0, $ordem='asc');
			 $this->dados["sensores"] = $this->M_sensores->pesquisar();
		}else{
			// $this->dados["sensores"] = $this->M_sensores->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);
			$this->dados["sensores"] = $this->M_sensores->pesquisar();
			$this->dados["contextointeresse"] = $this->M_contextosinteresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);
		}
		if(!isset($this->dados["editable"])){
			$this->dados["editable"] = "false";
		}
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('cadastros/regras_cs/cadastro');
			// $this->load->view('cadastros/regras_sb/cadastro');
		$this->load->view('inc/rodape');

	}

	function gravar(){
		if(isset($_POST["id_rule"])and $_POST["id_rule"] != ""){
			$this->M_Regras_SB->setRegraId($_POST["id_rule"]);
		}
		$this->M_Regras_SB->setRegraNome($_POST["name_rule"]);
		$this->M_Regras_SB->setRegraStatus($_POST["status"]);
		$this->M_Regras_SB->setRegraArquivoPy($_POST["rule"]);
		$this->M_Regras_SB->setRegraTipo(3);
		$this->M_Regras_SB->setSensor($_POST["id_sensor"]);
		if ($this->M_Regras_SB->salvar() == "inc"){
			$this->dados["msg"] = "Dados registrados com sucesso!";
		}
		else{
			$this->dados["msg"] = "Dados alterados com sucesso!";
		}
		$this->pesquisa();
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
		//  print_r($_POST);
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

	function getConditions($value="")
	{
		$condicoes = $this->M_conditions->get_conditions_CS();
		$output    = array();
		foreach($condicoes as $v) {
			$tipo = 'number';
			if($v['tipo']=="Estado de Evento"){
					$tipo = 'string';
			}
				$obj      = array('url'=> $v['url'],'nome_legivel'=>$v['tipo']." do".$v['nome'],'tipo'=>$tipo,"sensor"=>$v['id_sensor'],'nome' => 'get_verify_sensor');
				$obj      = json_encode($obj,JSON_FORCE_OBJECT);
				$output[] = $obj;
					}
			echo json_encode($output);
		// echo $output;

	}

	function getActions($value="") // busca no banco as açoes pre definidas e retorna para a app
	{
		$actions = $this->M_actions->get_acoes_CS();
		$output    = array();

		foreach($actions as $v) {
				$obj      = array('nome_legivel'=>$v['nome_legivel'],'nome'=>$v['nome']);
				$obj      = json_encode($obj,JSON_FORCE_OBJECT);
				$output[] = $obj;
					}
			echo json_encode($output);

}
function sendInformation($value='')
{

	$actions              = $this->M_actions->get_acoes_CS();
	$condicoes            = $this->M_conditions->get_conditions_CS();
	$output               = array();
	$output_condiction    = array();
	$output_action        = array();
	$rule                 = $this->M_regras->selecionar($_POST["index"])->result_array();
	$rule 								= $rule[0]["arquivo_py"];
	foreach($actions as $v) {
			$obj              = array('nome_legivel'=>$v['nome_legivel'],'nome'=>$v['nome']);
			$obj              = json_encode($obj,JSON_FORCE_OBJECT);
			$output_action[]  = $obj;
	}
	foreach($condicoes as $v) {
		$tipo = 'number';
		if($v['tipo']=="Estado de Evento"){
				$tipo = 'string';
		}
				$obj                  = array('nome'=> $v['nome'],'nome_legivel'=>$v['tipo']." do ".$v['nome'],'tipo'=>$tipo,"sensor"=>$v['sensor_id']);
				$obj                  = json_encode($obj,JSON_FORCE_OBJECT);
				$output_condiction[]  = $obj;
	}
	$output               = array('rule'=>$rule,"condictions" =>$output_condiction,"action"=>$output_action);
	echo json_encode($output);
	// echo $rule;
}


}

?>
