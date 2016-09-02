<?php
class M_sensor extends CI_Model{
	private $sensor_id;
	private $sensor_nome;
	private $sensor_desc;
	private $sensor_modelo;
	private $sensor_precisao;
	private $sensor_valormin;
	private $sensor_valormax;
	private $sensor_fabricante;
	private $sensor_tipo;
	private $sensor_ambiente;
	private $sensor_gateway;
	private $sensor_servidorborda;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->select('sensor.*');

            $this->db->select('f.nome as fabricante_nome');
            $this->db->select('t.nome as tiposensor_nome');
            $this->db->select('e.nome as ambiente_nome');
            $this->db->select('g.nome as gateway_nome');
            $this->db->select('b.nome as servidorborda_nome');

            $this->db->from('sensor');

            $this->db->join('fabricante as f', 'sensor.fabricante_id = f.fabricante_id', 'left');
            $this->db->join('tiposensor as t', 'sensor.tiposensor_id = t.tiposensor_id', 'left');
            $this->db->join('ambiente as e', 'sensor.ambiente_id = e.ambiente_id', 'left');
            $this->db->join('gateway as g', 'sensor.gateway_id = g.gateway_id', 'left');
            $this->db->join('servidorborda as b', 'sensor.servidorborda_id = b.servidorborda_id', 'left');

            $this->db->where($where);
            $this->db->order_by('sensor_id',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {

        	$this->db->select('sensor.*');

            $this->db->select('t.unidade as unidade');

            $this->db->from('sensor');

            $this->db->join('tiposensor as t', 'sensor.tiposensor_id = t.tiposensor_id', 'left');

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
                "fabricante_id" 	=> $this->sensor_fabricante,
                "tiposensor_id" 	=> $this->sensor_tipo,
                "ambiente_id" 		=> $this->sensor_ambiente,
                "gateway_id" 		=> $this->sensor_gateway,
                "servidorborda_id" 	=> $this->sensor_servidorborda,
            );
			
			$arrayCampos=array_filter($arrayCampos);

			if ($this->sensor_id == ""){
	            $this->db->insert('sensor', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('sensor', $arrayCampos, array("sensor_id"=>$this->sensor_id));
		        return "alt";
        	}
		}

		function salvaSensor() {
            $arrayCampos  = array(
                "nome" 				=> $this->sensor_nome,
                "descricao" 		=> $this->sensor_desc,
                "modelo" 			=> $this->sensor_modelo,
                "precisao" 			=> $this->sensor_precisao,
                "gateway_id" 		=> $this->sensor_gateway,
                "servidorborda_id" 	=> $this->sensor_servidorborda,
            );


			if ($this->checkByGatewayNome($this->sensor_gateway, $this->sensor_nome) > 0){
				$where = array(
					"gateway_id"=>$this->sensor_gateway,
					"nome"=>$this->sensor_nome
				);
            	$this->db->update('sensor', $arrayCampos, $where);
            	$this->db->where($where);
				$insert_id = $this->db->get('sensor')->row()->sensor_id;

				$publicType = "update";
            }else{
            	$this->db->insert('sensor', $arrayCampos);
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
            $this->db->from('sensor');
            return $this->db->count_all_results();
        }
		
		function excluir() {
            $arrayCampos  = array(
                "sensor_id" => $this->sensor_id                
            );
            if ($this->db->delete('sensor', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('sensor');
            return $this->db->count_all_results();
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
		
		
		public function setSensorId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
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
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->sensor_precisao = $valor;
		}
		
		public function setSensorValorMin($valor){
			$this->sensor_valormin = $valor;
		}

		public function setSensorValorMax($valor){
			$this->sensor_valormax = $valor;
		}
		
		public function setSensorFabricante($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
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
		
	}
?>