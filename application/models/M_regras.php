<?php

class M_regras extends CI_Model {
	private $regra_id;
	private $regra_status;
	private $regra_tipo;
	private $regra_nome;
	private $regra_contextointeresse;
	private $regra_sensor;
	private $regra_arquivo_py;
	private $id_regra_borda;
        function pesquisar($select='',$where=array(), $limit=10, $offset=0, $ordem='asc', $perm=FALSE,$sens='',$or_where=array() ) {
        	if ($perm == FALSE){
	            $this->db->select('r.*');
							$this->db->select('borda.nome as borda_nome');
							// $this->db->select('borda.*');

	            // $this->db->select('ci.nome as contextointeresse_nome');
	            // $this->db->select('s.nome as sensor_nome');
	            $this->db->from('regras as r');
	            $this->db->join('sensores as sensor', 'r.sensor_id = sensor.sensor_id', 'left');
	            $this->db->join('servidoresborda as borda', 'borda.servidorborda_id = sensor.servidorborda_id', 'left');
	            // $this->db->join('sensor as s', 's.sensor_id = rci.sensor_id', 'left');
	        }else{
	        		$this->db->select('r.*');
	            $this->db->select('p.podeeditar as podeeditar');
							$this->db->select('borda.nome as borda_nome');

	            // $this->db->select('ci.nome as contextointeresse_nome');
	            // $this->db->select('s.nome as sensor_nome');
	            $this->db->from('regras as r');
	            // $this->db->join('permissoes as p', 'r.regra_id = p.regra_id', 'inner');
	            $this->db->join('contextosinteresse as ci', 'ci.regra_id = r.regra_id');
	            $this->db->join('permissoes as p', 'ci.contextointeresse_id = p.contextointeresse_id', 'inner');
							$this->db->join('sensores as sensor', 'r.sensor_id = sensor.sensor_id', 'left');
							$this->db->join('servidoresborda as borda', 'borda.servidorborda_id = sensor.servidorborda_id', 'left');
							// $this->db->join('relcontextointeresse as rci', 'r.regra_id = rci.regra_id', 'left');
	            // $this->db->join('contextointeresse as ci', 'ci.contextointeresse_id = rci.contextointeresse_id', 'left');
	            // $this->db->join('sensor as s', 's.sensor_id = rci.sensor_id', 'left');
	        }
						$this->db->where($where);
            $this->db->or_where($or_where);
            $this->db->order_by('r.nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
				function pesquisar_borda($select='',$where=array(), $limit=10, $offset=0, $ordem='asc', $perm=FALSE,$sens='',$or_where=array() ) {
        	if ($perm == FALSE){
	            $this->db->select('r.*');
							$this->db->select('borda.nome as borda_nome');
	            $this->db->from('regras as r');
	            $this->db->join('sensores as sensor', 'r.sensor_id = sensor.sensor_id', 'left');
	            $this->db->join('servidoresborda as borda', 'borda.servidorborda_id = sensor.servidorborda_id', 'left');

	        }else{
	        		$this->db->select('r.*');
	            $this->db->select('p.podeeditar as podeeditar');
							$this->db->select('borda.nome as borda_nome');

	            $this->db->from('regras as r');
	            $this->db->join('contextosinteresse as ci', 'ci.regra_id = r.regra_id');
	            $this->db->join('permissoes as p', 'ci.contextointeresse_id = p.contextointeresse_id', 'inner');
							$this->db->join('sensores as sensor', 'r.sensor_id = sensor.sensor_id', 'left');
							$this->db->join('servidoresborda as borda', 'borda.servidorborda_id = sensor.servidorborda_id', 'left');

	        }
						$this->db->where($where);
            $this->db->where($or_where);
            $this->db->order_by('r.nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
        function selecionar($codigo) {
        	$this->db->select('regras.*');
        	// $this->db->select('rci.contextointeresse_id');
        	// $this->db->select('rci.sensor_id');
            $this->db->from('regras');
            // $this->db->join('relcontextointeresse as rci', 'regras.regra_id = rci.regra_id', 'left');
            $this->db->where("regras.regra_id", $codigo);
            return $this->db->get();
        }
		function salvar() {
            $arrayCampos  = array(
                "status" 		  => $this->regra_status,
                "nome" 			  => $this->regra_nome,
                "tipo" 			  => $this->regra_tipo,
                "arquivo_py" 	=> $this->regra_arquivo_py
            );
			if ($this->regra_id == ""){
	            $this->db->insert('regras', $arrayCampos);
			    		$insert_id = $this->db->insert_id();
			    		// old "insert regra_id into relcontextointeresse"
							//$this->db->update('relcontextointeresse', array('regra_id' => $insert_id), array("contextointeresse_id"=>$this->regra_contextointeresse,"sensor_id"=>$this->regra_sensor));
		        return "inc";
			}else{
	            $this->db->update('regras', $arrayCampos, array("regra_id"=>$this->regra_id));
	            /*$this->db->set('regra_id', null);
				$this->db->where('regra_id', $this->regra_id);
				$this->db->update('relcontextointeresse');
				$this->db->set('regra_id', $this->regra_id);
				$this->db->where(array("contextointeresse_id"=>$this->regra_contextointeresse,"sensor_id"=>$this->regra_sensor));
				$this->db->update('relcontextointeresse');*/
		        return "alt";
        	}
		}
		function excluir() {
            $arrayCampos  = array(
                "regra_id" => $this->regra_id
            );
            if ($this->db->delete('regras', $arrayCampos)){
	            if ($this->db->delete('regras', $arrayCampos))
		            return true;
		        else
		        	return false;
		    }
		}
		function numeroLinhasTotais($select='', $where=array(), $or_where=array()) {
	    		$this->db->where($where);
					$this->db->or_where($or_where);
	        $this->db->from('regras');
	        return $this->db->count_all_results();
	    }
	    function altStatus() {
        	$arrayCampos  = array(
                "status" 	=> $this->regra_status
            );
			$this->db->update('regras', $arrayCampos, array("regra_id"=>$this->regra_id));
	        return "alt";
        }
// Getters and Setters
		public function getRegraId(){
			if($this->regra_id === NULL) {
				$this->regra_id = new RegraId;
			}
			return $this->regra_id;
		}
		public function getRegraNome() {
		    if($this->regra_nome === NULL) {
        		$this->regra_nome = new RegraNome;
    		}
			return $this->regra_nome;
		}
		public function getRegraStatus() {
		    if($this->regra_status === NULL) {
        		$this->regra_status = new RegraStatus;
    		}
			return $this->regra_status;
		}
		public function getRegraTipo() {
		    if($this->regra_tipo === NULL) {
        		$this->regra_tipo = new RegraTipo;
    		}
			return $this->regra_tipo;
		}
		public function getRegraArquivoPy() {
		    if($this->regra_arquivo_py === NULL) {
        		$this->regra_arquivo_py = new RegraArquivoPy;
    		}
			return $this->regra_arquivo_py;
		}
		/*public function getRegraContextoInteresse() {
		    if($this->regra_contextointeresse === NULL) {
        		$this->regra_contextointeresse = new RegraContextoInteresse;
    		}
			return $this->regra_contextointeresse;
		}
		public function getRegraSensor() {
		    if($this->regra_sensor === NULL) {
        		$this->regra_sensor = new RegraSensor;
    		}
			return $this->regra_sensor;
		}*/
		public function setRegraId($valor){
			$this->regra_id = $valor;
		}
		public function setRegraNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->regra_nome = $valor;
		}
		public function setRegraStatus($valor){
			$this->regra_status = $valor;
		}
		public function setRegraTipo($valor){
			$this->regra_tipo = $valor;
		}
		public function setRegraArquivoPy($valor){
			$this->regra_arquivo_py = $valor;
		}
		/*public function setRegraContextoInteresse($valor){
			$this->regra_contextointeresse = $valor;
		}
		public function setRegraSensor($valor){
			$this->regra_sensor = $valor;
		}*/
	}
?>
