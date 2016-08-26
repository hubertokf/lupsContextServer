<?php
class M_Regras_SB extends CI_Model{
    private $ambiente_id;
    private $ambiente_nome;
    private $ambiente_desc;
    private $ambiente_status;

        public function get_conditions($value='')
        {
          $this->db->select('*');
          $this->db->from('condicoes');
          $this->db->where('tipo_server = 1');
          $respost = $this->db->get()->result_array();
          //  echo "<br>";
          return $respost;
        }
        public function get_acoes($value='')
        {
          $this->db->select('*');
          $this->db->from('acoes');
          $this->db->where('tipo_server = 1');
          $respost = $this->db->get()->result_array();
          //  echo "<br>";
          return $respost;
        }
        function selecionar($codigo) {
            $this->db->where("ambiente_id", $codigo);
            return $this->db->get('ambiente');
        }

        function altStatus() {
        	$arrayCampos  = array(
                "status" 	=> $this->ambiente_status
            );
			$this->db->update('ambiente', $arrayCampos, array("ambiente_id"=>$this->ambiente_id));
	        return "alt";
        }

		function salvar() {
            $arrayCampos  = array(
                "nome"					=> $this->ambiente_nome,
                "descricao" 			=> $this->ambiente_desc,
                "status" 				=> $this->ambiente_status,
            );
			if ($this->ambiente_id == ""){
	            $this->db->insert('ambiente', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('ambiente', $arrayCampos, array("ambiente_id"=>$this->ambiente_id));
		        return "alt";
        	}
		}

		function excluir() {
            $arrayCampos  = array(
                "ambiente_id" => $this->ambiente_id
            );
            if ($this->db->delete('ambiente', $arrayCampos))
	            return true;
	        else
	        	return false;
		}

        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('ambiente');
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
