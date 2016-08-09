<?php
	class M_publicacao extends CI_Model{
		private $publicacao_id;
		private $publicacao_servidorborda;
		private $publicacao_sensor;
		private $publicacao_datacoleta;
		private $publicacao_datapublicacao;
		private $publicacao_valorcoletado;

	    function pesquisar($select='', $where=array(), $limit=10, $offset=0, $orderby='publicacao_id', $ordem='asc', $perm=FALSE, $whereOR=array()) {
	    	if ($perm == FALSE){
		        $this->db->select('pu.*');

				$this->db->select('b.nome as servidorborda_nome');
				$this->db->select('s.nome as sensor_nome');
				$this->db->select('ts.unidade as tiposensor_unidade');			

		        $this->db->from('publicacao as pu');

				$this->db->join('servidorborda as b', 'pu.servidorborda_id = b.servidorborda_id', 'left');
				$this->db->join('sensor as s','pu.sensor_id = s.sensor_id', 'left');
				$this->db->join('tiposensor as ts','s.tiposensor_id = ts.tiposensor_id', 'left');
		    }else{
		    	$this->db->select('pu.*');

				$this->db->select('b.nome as servidorborda_nome');
				$this->db->select('s.nome as sensor_nome');
				$this->db->select('ts.unidade as tiposensor_unidade');
	            $this->db->select('p.podeeditar as podeeditar');

		        $this->db->from('publicacao as pu');

				$this->db->join('servidorborda as b', 'pu.servidorborda_id = b.servidorborda_id', 'left');
				$this->db->join('sensor as s','pu.sensor_id = s.sensor_id', 'left');

	            $this->db->join('relcontextointeresse as rci', 'rci.sensor_id = s.sensor_id');
	            $this->db->join('permissoes as p', 'rci.contextointeresse_id = p.contextointeresse_id', 'inner');
	            $this->db->join('contextointeresse as ci', 'ci.contextointeresse_id = rci.contextointeresse_id');

				$this->db->join('tiposensor as ts','s.tiposensor_id = ts.tiposensor_id', 'left');
		    }
		    
	        $this->db->where($where);
	        $this->db->or_where($whereOR);
	        $this->db->order_by($orderby,$ordem);
	   	    $this->db->limit($limit, $offset);

	        return $this->db->get();
	    }
		
	    function selecionar($codigo) {
	        $this->db->where("publicacao_id", $codigo);
	        return $this->db->get('publicacao');
	    }

	    function getDataByDay($where=array()){
	    	$this->db->select('publicacao.valorcoletado, publicacao.datacoleta');

			$this->db->select('s.nome as sensor_nome');
			$this->db->select('ts.unidade as tiposensor_unidade');			

	        $this->db->from('publicacao');

			$this->db->join('sensor as s','publicacao.sensor_id = s.sensor_id', 'left');
			$this->db->join('tiposensor as ts','s.tiposensor_id = ts.tiposensor_id', 'left');

	        $this->db->where($where);
	        $this->db->order_by("datacoleta","desc");

	        return $this->db->get();
	    }

	    function selBySensorID($codigo, $where=array()) {
	    	
			$this->db->select('valorcoletado, publicacao.datacoleta');
			$this->db->select('s.nome as sensor_nome');
			$this->db->select('ts.unidade as tiposensor_unidade');			

	        $this->db->from('publicacao');

			$this->db->join('sensor as s','publicacao.sensor_id = s.sensor_id', 'left');
			$this->db->join('tiposensor as ts','s.tiposensor_id = ts.tiposensor_id', 'left');

			$this->db->where("publicacao.sensor_id", $codigo);
			$this->db->where($where);
			$this->db->order_by('datacoleta','asc');
	        
	        return $this->db->get();
	    }

		function salvar() {
	        $arrayCampos  = array(
	            "servidorborda_id"	=> $this->publicacao_servidorborda,
	            "sensor_id" 		=> $this->publicacao_sensor,
	            "datacoleta" 		=> $this->publicacao_datacoleta,
	            "datapublicacao"	=> $this->publicacao_datapublicacao,
	            "valorcoletado"		=> $this->publicacao_valorcoletado
	        );
			if ($this->publicacao_id == ""){
	            $this->db->insert('publicacao', $arrayCampos);
		        return "inc";
			}
	    	else{
	            $this->db->update('publicacao', $arrayCampos, array("publicacao_id"=>$this->publicacao_id));
		        return "alt";
	    	}
		}

		function salvaPublicacao() {
	        $arrayCampos  = array(
	            "servidorborda_id"	=> $this->publicacao_servidorborda,
	            "sensor_id" 		=> $this->publicacao_sensor,
	            "datacoleta" 		=> $this->publicacao_datacoleta,
	            "datapublicacao"	=> $this->publicacao_datapublicacao,
	            "valorcoletado"		=> $this->publicacao_valorcoletado
	        );
	        $this->db->insert('publicacao', $arrayCampos);
            $insert_id = $this->db->insert_id();

			return  $insert_id;
		}
		
		function excluir() {
	        $arrayCampos  = array(
	            "publicacao_id" => $this->publicacao_id                
	        );
	        if ($this->db->delete('publicacao', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
	    function numeroLinhasTotais($select='', $where=array(), $perm=FALSE) {
	    	if ($perm == FALSE){
		        $this->db->from('publicacao as pu');

				$this->db->join('servidorborda as b', 'pu.servidorborda_id = b.servidorborda_id', 'left');
				$this->db->join('sensor as s','pu.sensor_id = s.sensor_id', 'left');
				$this->db->join('tiposensor as ts','s.tiposensor_id = ts.tiposensor_id', 'left');
		    }else{
		        $this->db->from('publicacao as pu');

				$this->db->join('servidorborda as b', 'pu.servidorborda_id = b.servidorborda_id', 'left');
				$this->db->join('sensor as s','pu.sensor_id = s.sensor_id', 'left');

	            $this->db->join('relcontextointeresse as rci', 'rci.sensor_id = s.sensor_id');
	            $this->db->join('permissoes as p', 'rci.contextointeresse_id = p.contextointeresse_id', 'inner');

				$this->db->join('tiposensor as ts','s.tiposensor_id = ts.tiposensor_id', 'left');
		    }
		    
	        $this->db->where($where);

	        return $this->db->count_all_results();
	    }

	    function getMMM($where=array()){ //Media Maximo e Mínimo
	    	$this->db->select_max('publicacao.valorcoletado', 'valor_max');
	    	$this->db->select_min('publicacao.valorcoletado', 'valor_min');
	    	$this->db->select_avg('publicacao.valorcoletado', 'valor_med');	

	        $this->db->from('publicacao');

	        $this->db->where($where);

	        return $this->db->get();
	    }
		
// Getters and Setters 
	
		public function getPublicacaoId(){
			if($this->publicacao_id === NULL) {
				$this->publicacao_id = new PublicacaoId;
			}
			return $this->publicacao_id;
		}
	
		public function getPublicacaoservidorborda(){
			if($this->publicacao_servidorborda === NULL) {
				$this->publicacao_servidorborda = new Publicacaoservidorborda;
			}
			return $this->publicacao_servidorborda;
		}
	
		public function getPublicacaoSensor(){
			if($this->publicacao_sensor === NULL) {
				$this->publicacao_sensor = new PublicacaoSensor;
			}
			return $this->publicacao_sensor;
		}
	
		public function getPublicacaoDataColeta(){
			if($this->publicacao_datacoleta === NULL) {
				$this->publicacao_datacoleta = new PublicacaoDataColeta;
			}
			return $this->publicacao_datacoleta;
		}
	
		public function getPublicacaoDataPublicacao(){
			if($this->publicacao_datapublicacao === NULL) {
				$this->publicacao_datapublicacao = new PublicacaoDataPublicacao;
			}
			return $this->publicacao_datapublicacao;
		}
	
		public function getPublicacaoValorColetado(){
			if($this->publicacao_valorcoletado === NULL) {
				$this->publicacao_valorcoletado = new PublicacaoValorColetado;
			}
			return $this->publicacao_valorcoletado;
		}
			
		public function setPublicacaoId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->publicacao_id = $valor;
		}
	
		public function setPublicacaoservidorborda($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->publicacao_servidorborda = $valor;
		}
	
		public function setPublicacaoSensor($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->publicacao_sensor = $valor;
		}
	
		public function setPublicacaoDataColeta($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->publicacao_datacoleta = $valor;
		}
	
		public function setPublicacaoDataPublicacao($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->publicacao_datapublicacao = $valor;
		}
	
		public function setPublicacaoValorColetado($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->publicacao_valorcoletado = $valor;
		}			
	}
?>