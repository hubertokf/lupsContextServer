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
			$this->load->model('M_contextosinteresse');
			$this->load->model('M_servidorcontexto');
			$this->load->model('M_gateways');
			$this->load->model('M_sensores');
			$this->load->model('M_publicacoes');
			$this->load->model('M_usuarios');
			$this->load->model('M_servidoresborda');
			$this->load->model('M_perfisusuarios');
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
			if ($this->session->userdata('usuario_id') != null){
				$perfilusuario_id = $this->session->userdata('perfilusuario_id');
				if ($this->M_perfisusuarios->isAdm($perfilusuario_id) == 't')
					$this->dados["contextos_interesse"] = $this->M_contextosinteresse->pesquisar('', array(), 10000, 0, 'asc', FALSE);			
				else
					$this->dados["contextos_interesse"] = $this->M_contextosinteresse->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 10000, 0, 'asc', TRUE);
			}else
				$this->dados["contextos_interesse"] = $this->M_contextosinteresse->pesquisar('', array('publico' => 'TRUE'), 10, 0, 'asc', FALSE);

			$this->dados["index"] = true;		
			$this->load->view('inc/topo',$this->dados);			
			$this->load->view('visualizacao/visualizacao');
			$this->load->view('inc/rodape');
		}

		function getSensoresByCiID($id=""){
			if ($id==""){	
				if(isset($_POST["contextointeresse"])) {
					$sensores = $this->M_contextosinteresse->selecionar($_POST["contextointeresse"]);
				}
			}else{
				$sensores = $this->M_contextosinteresse->selecionar($id);
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

			$this->dados["contextointeresse"] = $this->M_contextosinteresse->selecionarCI($_SESSION['contextointeresse']);

			foreach (array($_SESSION['sensor']) as $key => $value) {
				$this->dados["publicacoes"][] = $this->M_publicacoes->selBySensorID($value)->result_array();
				$sensor_temp = $this->M_sensores->selecionar($value)->result_array();
				$this->dados["sensor"][] = $sensor_temp[0];
			}

			$this->dados["serie"] = $this->geraJsonGrafico($this->dados["publicacoes"], $this->dados["sensor"]);

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu_vis');
			$this->load->view('visualizacao/grafico');
			$this->load->view('inc/rodape');
		}

		function comparar(){
			if (isset($_POST['contextointeresse'])) {
			     $_SESSION['contextointeresse'] = $_POST['contextointeresse'];
			}

			if(isset($_SESSION['contextointeresse'])) {
				$this->dados["contextointeresse"] = $this->M_contextosinteresse->pesquisar('', array('contextointeresse_id' => $_SESSION['contextointeresse']), 10, $this->uri->segment(5));
			}

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
				$this->dados["contextointeresse"] = $this->M_contextosinteresse->selecionarCI($_SESSION['contextointeresse']);

				foreach ($_POST['sensor'] as $key => $value) {

					$pub = $this->M_publicacoes->selBySensorID($value)->result_array();
					for ($i=0; $i < sizeof($pub); $i++) {
						$date = new DateTime($pub[$i]["datacoleta"]);
						$pub[$i]["datacoleta"] = $date->format('Y-m-d H:i');
					}
					$this->dados["publicacoes"][] = $pub;

					$sensor_temp = $this->M_sensores->selecionar($value)->result_array();

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
					$this->dados["publicacoes"][] = $this->M_publicacoes->selBySensorID($value,$where)->result_array();
					$sensor_temp = $this->M_sensores->selecionar($value)->result_array();

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
			
			$this->dados["contextointeresse"] = $this->M_contextosinteresse->selecionarCI($_SESSION['contextointeresse']);
			$this->dados["sensor"] = $this->M_sensores->selecionar($_SESSION['sensor'])->result_array();
			$dias = 7;
			$results = array();
			$meds = array();
			$meds2 = array();
			$date = date("Y-m-d");

			$i = 0;
			$limit = 0;
			while ($i <= 6) {
				$where = array(
					'publicacoes.sensor_id' => $_SESSION["sensor"],
					'DATE(datacoleta)' => $date
					);

				$rows = $this->M_publicacoes->getDataByDay($where)->result_array();
				

				if(!empty($rows)){
				
					array_push($results, $rows);
					array_push($meds, $this->M_publicacoes->getMMM($where)->result_array());

					$i++;
					$limit = 0;
				}else{
					$limit++;
				}

				$date = date('Y-m-d', strtotime($date . ' -1 day'));
				
				if($limit >= 120){
					break;
				}
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
			$this->dados["contextointeresse"] = $this->M_contextosinteresse->selecionarCI($_SESSION['contextointeresse']);

			$this->dados["sensor"] = $this->M_sensores->selecionar($_SESSION['sensor'])->result_array();

			if ($this->session->userdata('usuario_id') != null){
				$perfilusuario_id = $this->session->userdata('perfilusuario_id');
				if ($this->M_perfisusuarios->isAdm($perfilusuario_id) == 't'){
					$this->dados["sensores"] = $this->M_sensores->pesquisar('', array(), 10000, 0, 'asc', FALSE);
				}
				else
					$this->dados["sensores"] = $this->M_sensores->pesquisar('', array('p.usuario_id' => $this->session->userdata('usuario_id')), 10000, 0, 'asc', TRUE);
			}else{
				$this->dados["sensores"] = $this->M_sensores->pesquisar('', array('ci.publico' => 'TRUE'), 10000, 0, 'asc', FALSE);	
			}

			$this->dados["sensores"] = array_unique($this->dados["sensores"]->result_array(),SORT_REGULAR);

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu_vis');
			$this->load->view('visualizacao/busca');
			$this->load->view('inc/rodape');
		}

		function getResults($where, $whereOR){
			/*$fullSearch = "SELECT * FROM (SELECT contexto_dthr, to_char(contexto_dthr,'DD/MM/YYYY') 
				as data,to_char(contexto_dthr,'HH24:MI') as horario, sensor_vlr_flt, sensor_public.sensor_public_id, sensor_observacao
			FROM publicacoes
			inner join sensor_public on publicacoes.sensor_public_id = sensor_public.sensor_public_id " . $where . "
			 ORDER BY contexto_dthr ASC) AS A" ;*/
			$perfilusuario_id = $this->session->userdata('perfilusuario_id');
			if ($this->M_perfisusuarios->isAdm($perfilusuario_id) == 't')
				$dados = $this->M_publicacoes->pesquisar('', $where, 100000, 0, "datacoleta", 'asc', FALSE, $whereOR);
			else{
				if ($this->session->userdata('usuario_id') != null)
					$dados = $this->M_publicacoes->pesquisar('', array_merge($where, array('p.usuario_id' => $this->session->userdata('usuario_id'))), 100000, 0, 'datacoleta', 'asc', TRUE, $whereOR);
				else
					$dados = $this->M_publicacoes->pesquisar('', array_merge($where, array('ci.publico' => true)), 100000, 0, 'datacoleta', 'asc', TRUE, $whereOR);

			}
	   	    //echo $this->db->last_query();
	   	    $dados = $dados->result_array();
			//print "<pre>";
			//print_r($dados->result_array());
			//print "</pre>";
			$table=	'[["SensorId","DataCompleta","Medicao"],';
			$total = count($dados);
			$i=0;
			$totalMedicao=0;
			$media=0;
			$desvioPadrao=0;
			if($total != 0 ){
				foreach ($dados as $dado) {
					//print_r($dado);
					$myvar = $dado['valorcoletado'];
					$tmp = strlen($myvar);
					$strObs = (string)$dado['valorcoletado'];

					$fltObs = (float)$strObs;

					$table .= '["'.$dado['sensor_id'].'","'.$dado['datacoleta'].'","'.$dado['valorcoletado'].'"]';
					$i++;

					if($i!=$total)
					{
						$table .=',';
					}
				}
				$table.=']';
				return $table;
			}else
				return '';
		}

		function checkServerStatus(){
    		$url = $this->input->get('addr');
			$curl  = curl_init($url);

			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,5); 
			curl_setopt($curl, CURLOPT_TIMEOUT, 5);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($curl);
			$info = curl_getinfo($curl);

			curl_close($curl);

			if ($info['http_code'] == 200)
				echo TRUE;
			else
				echo FALSE;
    	}

		function buscaTeste(){
			//['data','valor','sensorId','sensorNome','hora']
			if($_POST['filtro']!=''){
				$filtroPost = $_POST['filtro'];

				$json=json_decode($filtroPost);

				if(json_last_error()==JSON_ERROR_NONE){

					$where = array(
						"datacoleta >=" => $json->dataInicial,
						"datacoleta <=" => $json->dataFinal
						);

					$whereOR = array();

					//$query="where  ( contexto_dthr >= TO_TIMESTAMP('".$json->dataInicial." ".$json->horaInicial.":00', 'DD/MM/YYYY HH24:MI:SS') AND contexto_dthr <= TO_TIMESTAMP('".$json->dataFinal." ".$json->horaFinal.":59', 		'DD/MM/YYYY HH24:MI:SS')	 		) AND ( (";
																																											
					$sensorId='';
					
					foreach($json->filtros as $filter){
						$subQuery='';
						switch($filter->conectorEOU){
							case 'AND':
								$arrayT = array("s.sensor_id" => $filter->sensorId,"valorcoletado ".$filter->operacaoLogica => (string)$filter->valor);
								$where = array_merge($where, $arrayT);
								break;
							case 'OR':
								$arrayT = array("s.sensor_id" => $filter->sensorId,"valorcoletado ".$filter->operacaoLogica => (string)$filter->valor);
								$whereOR = array_merge($whereOR, $arrayT);
								break;
							default:
							
								break;
							
						}
						if($filter->operacaoLogica!='all'){
							$arrayT = array("valorcoletado ".$filter->operacaoLogica => (string)$filter->valor);
							$where = array_merge($where, $arrayT);
						}
						
					}
					print_r(json_encode($this->getResults($where, $whereOR)));
				}else
					echo 'ERR1';
				
			}
		}
	}
?>
