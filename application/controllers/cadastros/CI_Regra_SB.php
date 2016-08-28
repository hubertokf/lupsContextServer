<?php

class CI_regra_SB extends CI_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_regras');
		$this->load->model('M_relcontextointeresse');
		$this->load->model('M_usuario');
		$this->load->model('M_contextointeresse');
		$this->load->model('M_sensor');
		$this->load->model('M_Regras_SB');
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
			$this->dados["linhas"] = $this->M_regras->pesquisar('', array(), $nr_pagina, $this->uri->segment(5), 'asc', FALSE);
		else
			$this->dados["linhas"] = $this->M_regras->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5), 'asc', TRUE);

		$this->dados["nr_pagina"] = $nr_pagina;
		$this->dados["total"] = $this->M_regras->numeroLinhasTotais();
		$this->dados["tituloPesquisa"] = "Regras Cadastradas";
		$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
		$pag['total_rows'] = $this->dados["total"];
		$pag['uri_segment']	= 5;
		$pag['per_page'] = $this->dados["nr_pagina"];
		$this->pagination->initialize($pag);
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('inc/topoPesquisa');
		$this->load->view('cadastros/regras_sb/pesquisaEca');
		$this->load->view('inc/rodape');
	}

	function cadastro(){

		$this->dados["regras"] = $this->M_regras->pesquisar();
		if ($this->session->userdata('perfilusuario_id') == 2)
			$this->dados["contextointeresse"] = $this->M_contextointeresse->pesquisar($select='', $where=array(), $limit=100, $offset=0, $ordem='asc');
		else
			$this->dados["contextointeresse"] = $this->M_contextointeresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 100, 0, 'asc', TRUE);

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');

			 $this->load->view('cadastros/regras_sb/cadastroEca');
			// $this->load->view('cadastros/regras_sb/cadastro');
			$this->load->view('inc/rodape');

	}

	function gravar(){
		if(isset($_POST["context"])){
			echo $_POST["context"];
		}
		print("Ok");
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
		} else if ($valor != "") {
			$this->dados["registro"] = $this->M_regras->selecionar($valor);
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
		// if ($id==""){
		// 	if(isset($_POST["contextointeresse"])) {
		// 		$sensores = $this->M_relcontextointeresse->getByCi($_POST["contextointeresse"]);
		// 	}
		// }else{
		// 	$sensores = $this->M_relcontextointeresse->getByCi($id);
		// }

	    echo json_encode($sensores);
	}

	function getConditions($value="")
	{
		$condicoes = $this->M_Regras_SB->get_conditions();
		$output    = array();

		foreach($condicoes as $v) {
				$obj      = array('nome'=> $v['nome'],'nome_legivel'=>$v['nome'],'tipo'=>$v['tipo']);

				$obj      = json_encode($obj,JSON_FORCE_OBJECT);
				$output[] = $obj;
					}
			echo json_encode($output);
		// echo $output;

	}

	function getActions($value="") // busca no banco as açoes pre definidas e retorna para a app
	{
		$actions = $this->M_Regras_SB->get_acoes();
		$output    = array();

		foreach($actions as $v) {
				$obj      = array('nome_legivel'=>$v['nome_legivel'],'nome'=>$v['nome']);
				$obj      = json_encode($obj,JSON_FORCE_OBJECT);
				$output[] = $obj;
					}
			echo json_encode($output);

}

}

?>
