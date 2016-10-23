<?php
	class M_perfisusuarios extends CI_Model{
	    private $perfilusuario_id;
	    private $perfilusuario_desc;
		private $perfilusuario_nome;
		private $perfilusuario_superAdm;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->from('perfisusuarios');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("perfilusuario_id", $codigo);
            return $this->db->get('perfisusuarios');
        }

        function isAdm($codigo){
        	$this->db->select('superAdm');
            $this->db->from('perfisusuarios');
            $this->db->where('perfilusuario_id',$codigo);

            return $this->db->get()->row()->superAdm;
        }

		function salvar() {
            $arrayCampos  = array(
                "descricao" 	=> $this->perfilusuario_desc,
                "nome" 			=> $this->perfilusuario_nome,
                "superAdm" 		=> $this->perfilusuario_superAdm
            );
			if ($this->perfilusuario_id == ""){
	            $this->db->insert('perfisusuarios', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('perfisusuarios', $arrayCampos, array("perfilusuario_id"=>$this->perfilusuario_id));
		        return "alt";
        	}
		}
		
		function salvarMenu($valor) {
			$arrayCampos = array(
				"perfilusuario_id"		=> $this->perfilusuario_id,
				"menu_id"		=> $valor 
			);
			$this->db->insert('perfisusuarios', $arrayCampos);
		}
		
		function excluir() {
            $arrayCampos  = array(
                "perfilusuario_id" => $this->perfilusuario_id                
            );
            if ($this->db->delete('perfisusuarios', $arrayCampos)){
            	if ($this->db->delete('perfisusuarios', $arrayCampos))
		            return true;
		        else
		        	return false;
		    }
		}
		
		function excluirMenus() {
			$arrayCampos  = array(
                "perfilusuario_id" => $this->perfilusuario_id                
            );
            if ($this->db->delete('relmenuperfil', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('perfisusuarios');
            return $this->db->count_all_results();
        }
	
		// Getters and Setters 
	
		public function getPerfilId(){
			if($this->perfilusuario_id === NULL) {
				$this->perfilusuario_id = new PerfilId;
			}
			return $this->perfilusuario_id;
		}
		
		public function getPerfilDesc() {
		    if($this->perfilusuario_desc === NULL) {
        		$this->perfilusuario_desc = new PerfilDesc;
    		}			
			return $this->perfilusuario_desc;
		}
		
		public function getPerfilNome() {
		    if($this->perfilusuario_nome === NULL) {
        		$this->perfilusuario_nome = new PerfilNome;
    		}			
			return $this->perfilusuario_nome;
		}	

		public function getPerfilSuperAdm() {
		    if($this->perfilusuario_superAdm === NULL) {
        		$this->perfilusuario_superAdm = new PerfilSuperAdm;
    		}			
			return $this->perfilusuario_superAdm;
		}	
		
		public function setPerfilId($valor){
			$this->perfilusuario_id = $valor;
		}
		
		public function setPerfilDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->perfilusuario_desc = $valor;
		}
		
		public function setPerfilNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->perfilusuario_nome = $valor;
		}

		public function setPerfilSuperAdm($valor){
			$this->perfilusuario_superAdm = $valor;
		}
		
	}
?>