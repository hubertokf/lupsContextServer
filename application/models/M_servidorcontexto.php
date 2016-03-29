<?php
	class M_servidorcontexto extends CI_Model{
	    private $servidorcontexto_id;
	    private $servidorcontexto_desc;
	    private $servidorcontexto_nome;
	    private $servidorcontexto_latitude;
	    private $servidorcontexto_longitude;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->from('servidorcontexto');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("servidorcontexto_id", $codigo);
            return $this->db->get('servidorcontexto');
        }
		function salvar() {
            $arrayCampos  = array(
                "descricao" 		=> $this->servidorcontexto_desc,
                "nome"		 		=> $this->servidorcontexto_nome,
                "latitude"			=> $this->servidorcontexto_latitude,
                "longitude"			=> $this->servidorcontexto_longitude
            );
			if ($this->servidorcontexto_id == ""){
	            $this->db->insert('servidorcontexto', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('servidorcontexto', $arrayCampos, array("servidorcontexto_id"=>$this->servidorcontexto_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "servidorcontexto_id" => $this->servidorcontexto_id                
            );
            if ($this->db->delete('servidorcontexto', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('servidorcontexto');
            return $this->db->count_all_results();
        }
	
		// Getters and Setters 
	
		public function getservidorcontextoId(){
			if($this->servidorcontexto_id === NULL) {
				$this->servidorcontexto_id = new servidorcontextoId;
			}
			return $this->servidorcontexto_id;
		}
		
		public function getservidorcontextoDesc() {
		    if($this->servidorcontexto_desc === NULL) {
        		$this->servidorcontexto_desc = new servidorcontextoDesc;
    		}			
			return $this->servidorcontexto_desc;
		}

		public function getservidorcontextoNome() {
		    if($this->servidorcontexto_nome === NULL) {
        		$this->servidorcontexto_nome = new servidorcontextoNome;
    		}			
			return $this->servidorcontexto_nome;
		}

		public function getservidorcontextoLatitude() {
		    if($this->servidorcontexto_latitude === NULL) {
        		$this->servidorcontexto_latitude = new servidorcontextoLatitude;
    		}			
			return $this->servidorcontexto_latitude;
		}

		public function getservidorcontextoLongitude() {
		    if($this->servidorcontexto_longitude === NULL) {
        		$this->servidorcontexto_longitude = new servidorcontextoLongitude;
    		}			
			return $this->servidorcontexto_longitude;
		}

		
		public function setservidorcontextoId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorcontexto_id = $valor;
		}
		
		public function setservidorcontextoNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorcontexto_nome = $valor;
		}

		public function setservidorcontextoLatitude($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorcontexto_latitude = $valor;
		}
		
		public function setservidorcontextoLongitude($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorcontexto_longitude = $valor;
		}

		public function setservidorcontextoDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorcontexto_desc = $valor;
		}

	}
?>