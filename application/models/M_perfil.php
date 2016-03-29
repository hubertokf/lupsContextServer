<?php
	class M_perfil extends CI_Model{
	    private $perfilusuario_id;
	    private $perfilusuario_desc;
		private $perfilusuario_nome;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->from('perfilusuario');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("perfilusuario_id", $codigo);
            return $this->db->get('perfilusuario');
        }
		function salvar() {
            $arrayCampos  = array(
                "descricao" 	=> $this->perfil_desc,
                "nome" 			=> $this->perfil_nome
            );
			if ($this->perfil_id == ""){
	            $this->db->insert('perfilusuario', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('perfilusuario', $arrayCampos, array("perfilusuario_id"=>$this->perfil_id));
		        return "alt";
        	}
		}
		
		function salvarMenu($valor) {
			$arrayCampos = array(
				"perfilusuario_id"		=> $this->perfil_id,
				"menu_id"		=> $valor 
			);
			$this->db->insert('relmenuperfil', $arrayCampos);
		}
		
		function excluir() {
            $arrayCampos  = array(
                "perfilusuario_id" => $this->perfil_id                
            );
            if ($this->db->delete('relmenuperfil', $arrayCampos)){
            	if ($this->db->delete('perfilusuario', $arrayCampos))
		            return true;
		        else
		        	return false;
		    }
		}
		
		function excluirMenus() {
			$arrayCampos  = array(
                "perfilusuario_id" => $this->perfil_id                
            );
            if ($this->db->delete('relmenuperfil', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('perfilusuario');
            return $this->db->count_all_results();
        }
	
		// Getters and Setters 
	
		public function getPerfilId(){
			if($this->perfil_id === NULL) {
				$this->perfil_id = new PerfilId;
			}
			return $this->perfil_id;
		}
		
		public function getPerfilDesc() {
		    if($this->perfil_desc === NULL) {
        		$this->perfil_desc = new PerfilDesc;
    		}			
			return $this->perfil_desc;
		}
		
		public function getPerfilNome() {
		    if($this->perfil_nome === NULL) {
        		$this->perfil_nome = new PerfilNome;
    		}			
			return $this->perfil_nome;
		}	
		
		public function setPerfilId($valor){
			$this->perfil_id = $valor;
		}
		
		public function setPerfilDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->perfil_desc = $valor;
		}
		
		public function setPerfilNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->perfil_nome = $valor;
		}
		
	}
?>