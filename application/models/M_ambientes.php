<?php
class M_ambientes extends CI_Model{
    private $ambiente_id;
    private $ambiente_nome;
    private $ambiente_desc;
    private $ambiente_status;
	
        function pesquisar($select='', $where=array(), $limit="", $offset=0, $ordem='asc', $perm=FALSE) {
        	if ($perm == FALSE){	            
	            $this->db->select('a.*');

	            $this->db->from('ambientes as a');

	        }else{
	        	$this->db->select('a.*');
	            $this->db->select('p.podeeditar as podeeditar');

	            $this->db->from('ambientes as a');

	            $this->db->join('sensores AS s', 's.ambiente_id = a.ambiente_id');
	            $this->db->join('relcontextointeresse AS rci', 'rci.sensor_id = s.sensor_id', 'inner');
	            $this->db->join('permissoes AS p', 'rci.contextointeresse_id = p.contextointeresse_id', 'inner');
	        }
            
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("ambiente_id", $codigo);
            return $this->db->get('ambientes');
        }

        function altStatus() {
        	$arrayCampos  = array(
                "status" 	=> $this->ambiente_status
            );
			$this->db->update('ambientes', $arrayCampos, array("ambiente_id"=>$this->ambiente_id));
	        return "alt";
        }

		function salvar() {
            $arrayCampos  = array(
                "nome"					=> $this->ambiente_nome,
                "descricao" 			=> $this->ambiente_desc,
                "status" 				=> $this->ambiente_status,
            );
			if ($this->ambiente_id == ""){
	            $this->db->insert('ambientes', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('ambientes', $arrayCampos, array("ambiente_id"=>$this->ambiente_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "ambiente_id" => $this->ambiente_id                
            );
            if ($this->db->delete('ambientes', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('ambientes');
            return $this->db->count_all_results();
        }
	
// Getters and Setters 
	
		public function getAmbienteId(){
			if($this->ambiente_id === NULL) {
				$this->ambiente_id = new AmbienteId;
			}
			return $this->ambiente_id;
		}

		public function getAmbienteNome() {
		    if($this->ambiente_nome === NULL) {
        		$this->ambiente_nome = new AmbienteNome;
    		}			
			return $this->ambiente_nome;
		}

		public function getAmbienteDesc() {
		    if($this->ambiente_desc === NULL) {
        		$this->ambiente_desc = new AmbienteDesc;
    		}			
			return $this->ambiente_desc;
		}

		public function getAmbienteStatus() {
		    if($this->ambiente_status === NULL) {
        		$this->ambiente_status = new AmbienteStatus;
    		}			
			return $this->ambiente_status;
		}
		
		public function setAmbienteId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->ambiente_id = $valor;
		}

		public function setAmbienteNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->ambiente_nome = $valor;
		}

		public function setAmbienteDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->ambiente_desc = $valor;
		}

		public function setAmbienteStatus($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->ambiente_status = $valor;
		}	
	}
?>