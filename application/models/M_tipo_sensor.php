<?php
class M_tipo_sensor extends CI_Model{
    private $tiposensor_id;
    private $tiposensor_nome;
    private $tiposensor_desc;
	private $tiposensor_unidade;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->from('tiposensor');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("tiposensor_id", $codigo);
            return $this->db->get('tiposensor');
        }
		function salvar() {
            $arrayCampos  = array(
            	"nome" 			=> $this->tiposensor_nome,
                "descricao" 	=> $this->tiposensor_desc,
                "unidade" 		=> $this->tiposensor_unidade,
            );
			if ($this->tiposensor_id == ""){
	            $this->db->insert('tiposensor', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('tiposensor', $arrayCampos, array("tiposensor_id"=>$this->tiposensor_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "tiposensor_id" => $this->tiposensor_id                
            );
            if ($this->db->delete('tiposensor', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('tiposensor');
            return $this->db->count_all_results();
        }
	
// Getters and Setters 
	
		public function getTipoSensorId(){
			if($this->tiposensor_id === NULL) {
				$this->tiposensor_id = new TipoSensorId;
			}
			return $this->tiposensor_id;
		}

		public function getTipoSensorNome() {
		    if($this->tiposensor_nome === NULL) {
        		$this->tiposensor_nome = new TipoSensorNome;
    		}			
			return $this->tiposensor_nome;
		}
		
		public function getTipoSensorDesc() {
		    if($this->tiposensor_desc === NULL) {
        		$this->tiposensor_desc = new TipoSensorDesc;
    		}			
			return $this->tiposensor_desc;
		}
		
		
		public function getTipoSensorUnidade() {
		    if($this->tiposensor_unidade === NULL) {
        		$this->tiposensor_unidade = new TipoSensorUnidade;
    		}			
			return $this->tiposensor_unidade;
		}		
		
		public function setTipoSensorId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->tiposensor_id = $valor;
		}

		public function setTipoSensorNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->tiposensor_nome = $valor;
		}
		
		public function setTipoSensorDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->tiposensor_desc = $valor;
		}
		
		public function setTipoSensorUnidade($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->tiposensor_unidade = $valor;
		}
		
	}
?>