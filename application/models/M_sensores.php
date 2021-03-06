<?php
class M_sensores extends CI_Model{
	private $sensor_id;
	private $sensor_nome;
	private $sensor_desc;
	private $sensor_modelo;
	private $sensor_precisao;
	private $sensor_valormin;
	private $sensor_valormax;
	private $sensor_valormin_n;
	private $sensor_valormax_n;
	private $sensor_inicio_luz;
	private $sensor_fim_luz;
	private $sensor_fabricante;
	private $sensor_tipo;
	private $sensor_ambiente;
	private $sensor_gateway;
	private $sensor_servidorborda;
	private $sensor_status;
	private $sensor_uuid;

  	function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc', $perm=FALSE) {
    	if ($perm == FALSE){
            $this->db->select($select);
            $this->db->select('s.*');

            $this->db->select('s.nome as sensor_nome');
            $this->db->select('s.descricao as sensor_descricao');
            $this->db->select('s.modelo as sensor_modelo');
            $this->db->select('f.nome as fabricante_nome');
            $this->db->select('t.nome as tiposensor_nome');
            $this->db->select('e.nome as ambiente_nome');
            $this->db->select('e.status as ambiente_status');
            $this->db->select('g.nome as gateway_nome');
            $this->db->select('b.nome as servidorborda_nome');

            $this->db->from('sensores as s');

            // $this->db->join('relcontextointeresse as rci', 'rci.sensor_id = s.sensor_id');
            // $this->db->join('contextointeresse as ci', 'ci.contextointeresse_id = rci.contextointeresse_id');

            $this->db->join('fabricantes as f', 's.fabricante_id = f.fabricante_id', 'left');
            $this->db->join('tipossensores as t', 's.tiposensor_id = t.tiposensor_id', 'left');
            $this->db->join('ambientes as e', 's.ambiente_id = e.ambiente_id', 'left');
            $this->db->join('gateways as g', 's.gateway_id = g.gateway_id', 'left');
            $this->db->join('servidoresborda as b', 's.servidorborda_id = b.servidorborda_id', 'left');

        }else{
        	$this->db->select($select);
            $this->db->select('s.*');

            $this->db->select('s.nome as sensor_nome');
            $this->db->select('s.descricao as sensor_descricao');
            $this->db->select('s.modelo as sensor_modelo');
            $this->db->select('f.nome as fabricante_nome');
            $this->db->select('t.nome as tiposensor_nome');
            $this->db->select('e.nome as ambiente_nome');
            $this->db->select('e.status as ambiente_status');
            $this->db->select('g.nome as gateway_nome');
            $this->db->select('b.nome as servidorborda_nome');
            $this->db->select('p.podeeditar as podeeditar');

            $this->db->from('sensores as s');

            $this->db->join('relcontextointeresse as rci', 'rci.sensor_id = s.sensor_id');
            $this->db->join('permissoes as p', 'rci.contextointeresse_id = p.contextointeresse_id', 'inner');
            $this->db->join('contextosinteresse as ci', 'ci.contextointeresse_id = rci.contextointeresse_id');

            $this->db->join('fabricantes as f', 's.fabricante_id = f.fabricante_id', 'left');
            $this->db->join('tipossensores as t', 's.tiposensor_id = t.tiposensor_id', 'left');
            $this->db->join('ambientes as e', 's.ambiente_id = e.ambiente_id', 'left');
            $this->db->join('gateways as g', 's.gateway_id = g.gateway_id', 'left');
            $this->db->join('servidoresborda as b', 's.servidorborda_id = b.servidorborda_id', 'left');
        }


        $this->db->where($where);
        $this->db->order_by('s.nome',$ordem);
   	    $this->db->limit($limit, $offset);

        return $this->db->get();

    }

    function get_borda_id($sensor){
    	$this->db->select('s.*');
			$this->db->select('t.unidade as unidade');
			$this->db->select("sb.url as bordaurl");
			$this->db->select("sb.access_token as bordatoken");
			$this->db->from('sensores as s');
			$this->db->join('tipossensores as t', 's.tiposensor_id = t.tiposensor_id', 'left');
			$this->db->join('servidoresborda as sb','sb.servidorborda_id = s.servidorborda_id');
			$this->db->where("sensor_id", $sensor);
			$return = $this->db->get()->result_array()[0];
			$ch     = curl_init($return['bordaurl'].'sensors/?uuID='.$return['uuid']);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			 	'Authorization: token '.$return['bordatoken'],
				'Content-Type: application/json')
			);
			$result = curl_exec($ch);
			curl_close($ch);
			// print_r("DDDD".$result);
			return json_decode($result)[0]->id;
    }

	function get_acesso_borda($where = array()){
		// return $this->db->select("borda.url a url, borda.access_token as token")
		// 		->from("servidorborda as borda")
		// 		->join('sensor as s','borda.servidorborda_id = s.servidorborda_id')
		// 		->where($where)
		// 	->get();
		$this->db->select("borda.url as url");
		$this->db->select("borda.access_token as token");
		$this->db->from("servidoresborda as borda");
		$this->db->join('sensores as s','borda.servidorborda_id = s.servidorborda_id');
		$this->db->where($where);
		return $this->db->get();
	}
    function selecionar($codigo) {

		$this->db->select('s.*');

		$this->db->select('t.unidade as unidade');
        $this->db->select('e.nome as ambiente_nome');
        $this->db->select('e.status as ambiente_status');
        $this->db->select('sb.nome as servidorborda_nome');

		$this->db->from('sensores as s');

		$this->db->join('tipossensores as t', 's.tiposensor_id = t.tiposensor_id', 'left');
        $this->db->join('ambientes as e', 's.ambiente_id = e.ambiente_id', 'left');
		$this->db->join('servidoresborda as sb','sb.servidorborda_id = s.servidorborda_id');

		$this->db->where("sensor_id", $codigo);
		return $this->db->get();
    }

	function salvar() {
          $arrayCampos  = array(
                "nome" 				=> $this->sensor_nome,
                "descricao" 		=> $this->sensor_desc,
                "modelo" 			=> $this->sensor_modelo,
                "precisao" 			=> $this->sensor_precisao,
                "valormin" 			=> $this->sensor_valormin,
                "valormax" 			=> $this->sensor_valormax,
				"valormin_n"		=> $this->sensor_valormin_n,
				"valormax_n"        => $this->sensor_valormax_n,
				"inicio_luz"        => $this->sensor_inicio_luz,
				"fim_luz"           => $this->sensor_fim_luz,
                "fabricante_id" 	=> $this->sensor_fabricante,
                "tiposensor_id" 	=> $this->sensor_tipo,
                "ambiente_id" 		=> $this->sensor_ambiente,
                "gateway_id" 		=> $this->sensor_gateway,
                "servidorborda_id" 	=> $this->sensor_servidorborda,
                "uuid" 				=> $this->sensor_uuid,
                "status" 			=> $this->sensor_status,
            );

			$arrayCampos=array_filter($arrayCampos, function($val) use (&$arrayCampos){
				if ($val !== null && $val !== false && $val !== ''){
					next($arrayCampos);
    				return true;
				}else{
					$this->db->set(key($arrayCampos), 'NULL', false);
					next($arrayCampos);
					return false;
				}
			});

			if ($this->sensor_id == ""){
	            $this->db->insert('sensores', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('sensores', $arrayCampos, array("sensor_id"=>$this->sensor_id));
		        return "alt";
        	}
		}

		function getBySBid($codigo) {
            $this->db->where("servidorborda_id", $codigo);
            return $this->db->get('sensores')->result_array();
        }

        function getByUuid($codigo) {
        	$this->db->select('s.*');
			$this->db->from('sensores as s');
        	$this->db->join('ambientes as e', 's.ambiente_id = e.ambiente_id');
        	$this->db->select('e.status as ambiente_status');
            $this->db->where("s.uuid", $codigo);
            return $this->db->get();

        }

		function salvaSensor() {
            $arrayCampos  = array(
                "nome" 				=> $this->sensor_nome,
                "descricao" 		=> $this->sensor_desc,
                "modelo" 			=> $this->sensor_modelo,
                "precisao" 			=> $this->sensor_precisao,
                "gateway_id" 		=> $this->sensor_gateway,
                "uuid" 				=> $this->sensor_uuid,
                "servidorborda_id" 	=> $this->sensor_servidorborda,
            );


			if ($this->checkByGatewayNome($this->sensor_gateway, $this->sensor_nome) > 0){
				$where = array(
					"gateway_id"=>$this->sensor_gateway,
					"nome"=>$this->sensor_nome
				);
            	$this->db->update('sensores', $arrayCampos, $where);
            	$this->db->where($where);
				$insert_id = $this->db->get('sensores')->row()->sensor_id;

				$publicType = "update";
            }else{
            	$this->db->insert('sensores', $arrayCampos);
            	$insert_id = $this->db->insert_id();

            	$publicType = "insert";
            }

			return  $publicType.":".$insert_id;
		}

		function checkByGatewayNome($gateway, $nome) {
			$where = array(
				"gateway_id"=>$gateway,
				"nome"=>$nome
			);
            $this->db->where($where);
            $this->db->from('sensores');
            return $this->db->count_all_results();
        }

		function excluir() {
            $arrayCampos  = array(
                "sensor_id" => $this->sensor_id
            );
            if ($this->db->delete('sensores', $arrayCampos))
	            return true;
	        else
	        	return false;
		}

        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('sensores');
            return $this->db->count_all_results();
        }

        function altStatus() {
        	$arrayCampos  = array(
                "status" 	=> $this->sensor_status
            );
			$this->db->update('sensores', $arrayCampos, array("sensor_id"=>$this->sensor_id));
	        return "alt";
        }

// Getters and Setters


		public function getSensorId(){
			if($this->sensor_id === NULL) {
				$this->sensor_id = new SensorId;
			}
			return $this->sensor_id;
		}

		public function getSensorNome() {
		    if($this->sensor_nome === NULL) {
        		$this->sensor_nome = new SensorNome;
    		}
			return $this->sensor_nome;
		}

		public function getSensorDesc() {
		    if($this->sensor_desc === NULL) {
        		$this->sensor_desc = new SensorDesc;
    		}
			return $this->sensor_desc;
		}

		public function getSensorModelo() {
		    if($this->sensor_modelo === NULL) {
        		$this->sensor_modelo = new SensorModelo;
    		}
			return $this->sensor_modelo;
		}

		public function getSensorPrecisao() {
		    if($this->sensor_precisao === NULL) {
        		$this->sensor_precisao = new SensorPrecisao;
    		}
			return $this->sensor_precisao;
		}

		public function getSensorValorMin() {
		    if($this->sensor_valormin === NULL) {
        		$this->sensor_valormin = new SensorValorMin;
    		}
			return $this->sensor_valormin;
		}

		public function getSensorValorMax() {
		    if($this->sensor_valormax === NULL) {
        		$this->sensor_valormax = new SensorValorMax;
    		}
			return $this->sensor_valormax;
		}

		public function getSensorValorMin_n() {
		    if($this->sensor_valormin_n === NULL) {
        		$this->sensor_valormin_n = new SensorValorMin_n;
    		}
			return $this->sensor_valormin_n;
		}

		public function getSensorValorMax_n() {
		    if($this->sensor_valormax_n === NULL) {
        		$this->sensor_valormax_n = new SensorValorMax_n;
    		}
			return $this->sensor_valormax_n;
		}

		public function getSensorInicioLuz() {
		    if($this->sensor_inicio_luz === NULL) {
        		$this->sensor_inicio_luz = new SensorInicioLuz;
    		}
			return $this->sensor_inicio_luz;
		}

		public function getSensorFimLuz() {
		    if($this->sensor_fim_luz === NULL) {
        		$this->sensor_fim_luz = new SensorFimLuz;
    		}
			return $this->sensor_fim_luz;
		}

		public function getSensorFabricante() {
		    if($this->sensor_fabricante === NULL) {
        		$this->sensor_fabricante = new SensorFabricante;
    		}
			return $this->sensor_fabricante;
		}

		public function getSensorTipo() {
		    if($this->sensor_tipo === NULL) {
        		$this->sensor_tipo = new SensorTipo;
    		}
			return $this->sensor_tipo;
		}

		public function getSensorAmbiente() {
		    if($this->sensor_ambiente === NULL) {
        		$this->sensor_ambiente = new SensorAmbiente;
    		}
			return $this->sensor_ambiente;
		}

		public function getSensorGateway() {
		    if($this->sensor_gateway === NULL) {
        		$this->sensor_gateway = new SensorGateway;
    		}
			return $this->sensor_gateway;
		}

		public function getSensorServidorBorda() {
		    if($this->sensor_servidorborda === NULL) {
        		$this->sensor_servidorborda = new SensorServidorBorda;
    		}
			return $this->sensor_servidorborda;
		}

		public function getSensorStatus() {
		    if($this->sensor_status === NULL) {
        		$this->sensor_status = new SensorStatus;
    		}
			return $this->sensor_status;
		}

		public function getSensorUuid() {
		    if($this->sensor_uuid === NULL) {
        		$this->sensor_uuid = new SensorUuid;
    		}
			return $this->sensor_uuid;
		}

		public function setSensorStatus($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_status = $valor;
		}

		public function setSensorId($valor){
			$this->sensor_id = $valor;
		}

		public function setSensorNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_nome = $valor;
		}

		public function setSensorDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_desc = $valor;
		}

		public function setSensorModelo($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_modelo = $valor;
		}

		public function setSensorPrecisao($valor){
			$this->sensor_precisao = $valor;
		}

		public function setSensorValorMin($valor){
			$this->sensor_valormin = $valor;
		}

		public function setSensorValorMax($valor){
			$this->sensor_valormax = $valor;
		}

		public function setSensorValorMin_n($valor){
			$this->sensor_valormin_n = $valor;
		}

		public function setSensorValorMax_n($valor){
			$this->sensor_valormax_n = $valor;
		}

		public function setSensorInicioLuz($valor){
			$this->sensor_inicio_luz = $valor;
		}

		public function setSensorFimLuz($valor){
			$this->sensor_fim_luz = $valor;
		}

		public function setSensorFabricante($valor){
			$this->sensor_fabricante = $valor;
		}

		public function setSensorTipo($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_tipo = $valor;
		}

		public function setSensorAmbiente($valor){
			$this->sensor_ambiente = $valor;
		}

		public function setSensorGateway($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_gateway = $valor;
		}

		public function setSensorServidorBorda($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_servidorborda = $valor;
		}

		public function setSensorUuid($valor){
			$this->sensor_uuid = $valor;
		}

	}
?>
