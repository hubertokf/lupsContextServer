<?php
	class CI_visualizacao extends CI_controller {
	
		public function __construct(){
			header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
			if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
			    die();
			}
			parent::__construct();
			
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
			$this->load->model('M_contextointeresse');
			$this->load->model('M_servidorcontexto');
			$this->load->model('M_gateway');
			$this->load->model('M_sensor');
			$this->load->model('M_publicacao');
			$this->load->model('M_servidorborda');
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
			if ($this->session->userdata('usuario_id') != null){
				if ($this->session->userdata('perfilusuario_id') == 2)
					$this->dados["sensores"] = $this->M_sensor->pesquisar('', array(), 10000, 0, 'asc', FALSE);
					//$this->dados["contextos_interesse"] = $this->M_contextointeresse->pesquisar('', array(), 10000, 0, 'asc', FALSE);			
				else
					$this->dados["sensores"] = $this->M_sensor->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 10000, 0, 'asc', TRUE);
					//$this->dados["contextos_interesse"] = $this->M_contextointeresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 10000, 0, 'asc', TRUE);
			}else
				$this->dados["sensores"] = $this->M_sensor->pesquisar('', array('ci.publico' => 'TRUE'), 10000, 0, 'asc', FALSE);			
				//$this->dados["contextos_interesse"] = $this->M_contextointeresse->pesquisar('', array('publico' => 'TRUE'), 10, 0, 'asc', FALSE);			
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('visualizacao/visualizacao');
			$this->load->view('inc/rodape');
		}

		function getSensoresByCiID($id=""){
			if ($id==""){	
				if(isset($_POST["contextointeresse"])) {
					$sensores = $this->M_contextointeresse->selecionar($_POST["contextointeresse"]);
				}
			}else{
				$sensores = $this->M_contextointeresse->selecionar($id);
			}

		    echo json_encode($sensores[0]['sensores']);
		}

		function grafico(){
			if (isset($_POST['contextointeresse'])) {
			     $_SESSION['contextointeresse'] = $_POST['contextointeresse'];
			}
			if (isset($_POST['sensor'])) {
			     $_SESSION['sensor'] = $_POST['sensor'];
			}

			//$this->dados["contextointeresse"] = $this->M_contextointeresse->selecionarCI($_SESSION['contextointeresse']);

			foreach (array($_SESSION['sensor']) as $key => $value) {
				$this->dados["publicacoes"][] = $this->M_publicacao->selBySensorID($value)->result_array();
				$sensor_temp = $this->M_sensor->selecionar($value)->result_array();
				$this->dados["sensor"][] = $sensor_temp[0];
			}

			$this->dados["serie"] = $this->geraJsonGrafico($this->dados["publicacoes"], $this->dados["sensor"]);

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu_vis');
			$this->load->view('visualizacao/grafico');
			$this->load->view('inc/rodape');
		}

		function comparar(){
			if ($this->session->userdata('usuario_id') != null){
				if ($this->session->userdata('perfilusuario_id') == 2)
					$this->dados["sensores"] = $this->M_sensor->pesquisar('', array(), 10000, 0, 'asc', FALSE);
					//$this->dados["contextos_interesse"] = $this->M_contextointeresse->pesquisar('', array(), 10000, 0, 'asc', FALSE);			
				else
					$this->dados["sensores"] = $this->M_sensor->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 10000, 0, 'asc', TRUE);
					//$this->dados["contextos_interesse"] = $this->M_contextointeresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 10000, 0, 'asc', TRUE);
			}else
				$this->dados["sensores"] = $this->M_sensor->pesquisar('', array('ci.publico' => 'TRUE'), 10000, 0, 'asc', FALSE);
			
			/*if (isset($_POST['contextointeresse'])) {
			     $_SESSION['contextointeresse'] = $_POST['contextointeresse'];
			}

			if(isset($_SESSION['contextointeresse'])) {
				$this->dados["contextointeresse"] = $this->M_contextointeresse->pesquisar('', array('contextointeresse_id' => $_SESSION['contextointeresse']), 10, $this->uri->segment(5));
			}*/

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu_vis');
			$this->load->view('visualizacao/comparar');
			$this->load->view('inc/rodape');
		}

		function comparaGrafico(){
			if (isset($_POST['contextointeresse'])) {
			     $_SESSION['contextointeresse'] = $_POST['contextointeresse'];
			}

			if (isset($_POST['sensor']) && is_array($_POST['sensor'])) {
				//$this->dados["contextointeresse"] = $this->M_contextointeresse->selecionarCI($_SESSION['contextointeresse']);

				foreach ($_POST['sensor'] as $key => $value) {
					$this->dados["publicacoes"][] = $this->M_publicacao->selBySensorID($value)->result_array();
					$sensor_temp = $this->M_sensor->selecionar($value)->result_array();

					$this->dados["sensor"][] = $sensor_temp[0];
				}

				$this->dados["serie"] = $this->geraJsonGrafico($this->dados["publicacoes"], $this->dados["sensor"]);

				$this->load->view('inc/topo',$this->dados);
				$this->load->view('inc/menu_vis');
				$this->load->view('visualizacao/grafico');
				$this->load->view('inc/rodape');
			}
		}

		function geraJsonSeries(){
			if (isset($_POST['sensor']) && is_array($_POST['sensor'])) {

				$where = array(
					'datacoleta >=' => $_POST['datainicio'],
					'datacoleta <=' => $_POST['datafim']
					);
				foreach ($_POST['sensor'] as $key => $value) {
					$this->dados["publicacoes"][] = $this->M_publicacao->selBySensorID($value,$where)->result_array();
					$sensor_temp = $this->M_sensor->selecionar($value)->result_array();

					$this->dados["sensor"][] = $sensor_temp[0];
				}

				$this->dados["serie"] = $this->geraJsonGrafico($this->dados["publicacoes"], $this->dados["sensor"]);

				echo $this->dados["serie"];
			}
		}

		function geraJsonGrafico($publicacoes, $sensores){
			$series = array();
			foreach ($sensores as $key => $sensor) {
				$serie = array();
				$serie['name'] = $sensor['nome'];
				$serie['tooltip'] = array("valueSuffix"=>$sensor["unidade"]);
				$serie['data'] = array();
				$serie['maxvalue'] = $sensor['valormax'];
				$serie['minvalue'] = $sensor['valormin'];
				foreach ($publicacoes[$key] as $publicacao) {
					$data = strtotime($publicacao['datacoleta']).'000';
					array_push($serie['data'], array((float)$data,(float)$publicacao['valorcoletado']));
				}
				array_push($series, $serie);
			}
				
			return json_encode($series, JSON_NUMERIC_CHECK);
		}

		function tabela(){
			if (isset($_POST['contextointeresse'])) {
			     $_SESSION['contextointeresse'] = $_POST['contextointeresse'];
			}
			if (isset($_POST['sensor'])) {
			     $_SESSION['sensor'] = $_POST['sensor'];
			}
			
			//$this->dados["contextointeresse"] = $this->M_contextointeresse->selecionarCI($_SESSION['contextointeresse']);
			$this->dados["sensor"] = $this->M_sensor->selecionar($_SESSION['sensor'])->result_array();
			$dias = 7;
			$results = array();
			$meds = array();
			$date = date("Y-m-d");
			
			for ($i = 0; $i < $dias; $i++) {

				$where = array(
					'publicacao.sensor_id' => $_SESSION["sensor"],
					'DATE(datacoleta)' => $date
					);

				$rows = $this->M_publicacao->getDataByDay($where)->result_array();

				array_push($results, $rows);
				array_push($meds, $this->M_publicacao->getMMM($where)->result_array());

				$date = date('Y-m-d', strtotime($date . ' -1 day'));
			}

			$this->dados["dias"] = $results;
			$this->dados["meds"] = $meds;

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu_vis');
			$this->load->view('visualizacao/tabela');
			$this->load->view('inc/rodape');
		}

		function busca(){
			if (isset($_POST['contextointeresse'])) {
			     $_SESSION['contextointeresse'] = $_POST['contextointeresse'];
			}
			if (isset($_POST['sensor'])) {
			     $_SESSION['sensor'] = $_POST['sensor'];
			}
			//$this->dados["contextointeresse"] = $this->M_contextointeresse->selecionarCI($_SESSION['contextointeresse']);
			$this->dados["sensor"] = $this->M_sensor->selecionar($_SESSION['sensor'])->result_array();

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu_vis');
			$this->load->view('visualizacao/busca');
			$this->load->view('inc/rodape');
		}
	}
?>
