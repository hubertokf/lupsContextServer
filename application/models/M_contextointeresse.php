<?php
class M_contextointeresse extends CI_Model {
	private $contextointeresse_id;
	private $contextointeresse_nome;
	private $contextointeresse_servidorcontexto;
	private $contextointeresse_sensores;
	private $contextointeresse_publico;
		
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc', $perm=FALSE) {
            if ($perm == FALSE){
	            $this->db->select('*');
	            
	            $this->db->from('contextointeresse');

	        }else{
	        	$this->db->select('*');
	            
	            $this->db->from('contextointeresse as ci');

	            $this->db->join('permissoes as p', 'ci.contextointeresse_id = p.contextointeresse_id', 'inner');
	        }

            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);

            $query = $this->db->get()->result_array();
			// Query #2

			$this->db->select('contextointeresse.*');	            
            $this->db->from('contextointeresse');
            $this->db->where(array('publico' => 'TRUE'));
			$query2 = $this->db->get()->result_array();

			// Merge both query results

			$query = array_unique(array_merge($query, $query2), SORT_REGULAR);

			$result = array();
			foreach($query as $arr){
			   if(!isset($result[$arr["contextointeresse_id"]])){
			      $result[$arr["contextointeresse_id"]] = $arr;
			   }
			}

	   	    foreach($result as $i=>$contextointeresse) {
	   	    	$this->db->select('*');
            	$this->db->select('s.nome as sensor_nome');

	        	$this->db->from('relcontextointeresse');
            	
            	$this->db->join('sensor as s', 'relcontextointeresse.sensor_id = s.sensor_id', 'left');

            	$this->db->where(array('contextointeresse_id' => $contextointeresse['contextointeresse_id']));

				$sensor_query = $this->db->get()->result_array();

			   	$result[$i]['sensores'] = $sensor_query;
			}

	        return $result;
        }

        function selecionar($codigo) {
            $this->db->where("contextointeresse_id", (string)$codigo);
            $query =  $this->db->get('contextointeresse')->result_array();

            foreach($query as $i=>$contextointeresse) {
	   	    	$this->db->select('*');
            	$this->db->select('s.nome as sensor_nome');

	        	$this->db->from('relcontextointeresse');
            	
            	$this->db->join('sensor as s', 'relcontextointeresse.sensor_id = s.sensor_id', 'left');

            	$this->db->where(array('contextointeresse_id' => $contextointeresse['contextointeresse_id']));

				$sensor_query = $this->db->get()->result_array();

			   	$query[$i]['sensores'] = $sensor_query;
			}

			return $query;
        }

		function selecionarCI($codigo) {
			$this->db->where("contextointeresse_id", $codigo);
            $query =  $this->db->get('contextointeresse')->result_array();

            return $query;
		}

		function salvar() {
            $arrayCampos  = array(
                "nome" 			=> $this->contextointeresse_nome,
                "servidorcontexto_id" 	=> $this->contextointeresse_servidorcontexto,
                "publico" => $this->contextointeresse_publico,
            );

            if ($this->contextointeresse_id == ""){
	            $this->db->insert('contextointeresse', $arrayCampos);
	            $insert_id = $this->db->insert_id();

	            foreach ($this->contextointeresse_sensores as $sensor) {
		            $arrayCampos2  = array(
						"contextointeresse_id" 		=> $insert_id,
		                "sensor_id"					=> $sensor
	             	);

			        $this->db->insert('relcontextointeresse', $arrayCampos2);
			    }

		        return "inc";
			}
        	else{
	            $this->db->update('contextointeresse', $arrayCampos, array("contextointeresse_id"=>$this->contextointeresse_id));

	            $arrayCampos  = array(
	                "contextointeresse_id" => $this->contextointeresse_id                
             	);
	            $this->db->delete('relcontextointeresse', $arrayCampos);

	            foreach ($this->contextointeresse_sensores as $sensor) {
	             	$arrayCampos2  = array(
		                "contextointeresse_id" 		=> $this->contextointeresse_id,
		                "sensor_id"					=> $sensor
	             	);
		            $this->db->insert('relcontextointeresse', $arrayCampos2);
		        }
		        return "alt";
        	}
		}

		function excluir() {
            $arrayCampos  = array(
                "contextointeresse_id" => $this->contextointeresse_id                
            );
            if ($this->db->delete('contextointeresse', $arrayCampos))
            	return true;
        	else
        		return false;
		}

		function numeroLinhasTotais($select='', $where=array()) {
    	$this->db->where($where);
        $this->db->from('contextointeresse');
        return $this->db->count_all_results();
    }
			
// Getters and Setters 

		public function getContextoInteresseId(){
			if($this->contextointeresse_id === NULL) {
				$this->contextointeresse_id = new ContextoInteresseId;
			}
			return $this->contextointeresse_id;
		}

		public function getContextoInteresseNome() {
		    if($this->contextointeresse_nome=== NULL) {
        		$this->contextointeresse_nome = new ContextoInteresseNome;
    		}			
			return $this->contextointeresse_nome;
		}

		public function getContextoInteresseServidorContexto() {
		    if($this->contextointeresse_servidorcontexto === NULL) {
        		$this->contextointeresse_servidorcontexto = new ContextoInteresseServidorContexto;
    		}			
			return $this->contextointeresse_servidorcontexto;
		}

		public function getContextoInteresseSensores() {
		    if($this->contextointeresse_sensores === NULL) {
        		$this->contextointeresse_sensores = new ContextoInteresseSensores;
    		}			
			return $this->contextointeresse_sensores;
		}

		public function getContextoInteressePublico() {
		    if($this->contextointeresse_publico === NULL) {
        		$this->contextointeresse_publico = new ContextoInteressePublico;
    		}			
			return $this->contextointeresse_publico;
		}

		public function setContextoInteresseId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->contextointeresse_id = $valor;
		}

		public function setContextoInteresseNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->contextointeresse_nome = $valor;
		}

		public function setContextoInteresseServidorContexto($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->contextointeresse_servidorcontexto = $valor;
		}

		public function setContextoInteresseSensores($valor){
			$this->contextointeresse_sensores = $valor;
		}

		public function setContextoInteressePublico($valor){
			$this->contextointeresse_publico = $valor;
		}
	}
?>