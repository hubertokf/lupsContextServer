<?php
class M_relmenuperfil extends CI_Model {
	private $menu_id;
	private $perfilusuario_id;
		
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select('relmenuperfil.*');
            
            $this->db->from('relmenuperfil');

            $this->db->where($where);
            $this->db->order_by('ordem',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }

        function selecionar($codigo) {
            $this->db->where("menu_id", $codigo);
            return $this->db->get('menu');
        }
		function salvar() {
            $arrayCampos  = array(
                "menu_id" 			=> $this->menu_id,
                "perfilusuario_id" 	=> $this->perfilusuario_id
            );
			if ($this->menu_id == ""){
	            $this->db->insert('relmenuperfil', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('menu', $arrayCampos, array("menu_id"=>$this->menu_id));
		        return "alt";
        	}
		}

		function excluir() {
            $arrayCampos  = array(
                "menu_id" => $this->menu_id                
            );
            if ($this->db->delete('relmenuperfil', $arrayCampos)){
	            if ($this->db->delete('relmenuperfil', $arrayCampos))
		            return true;
		        else
		        	return false;
		    }
		}
			
// Getters and Setters 

		public function getMenuId(){
			if($this->rel_menu_id === NULL) {
				$this->rel_menu_id = new MenuId;
			}
			return $this->rel_menu_id;
		}

		public function getPerfilUsuario() {
		    if($this->rel_perfilusuario === NULL) {
        		$this->rel_perfilusuario = new MenuNome;
    		}			
			return $this->rel_perfilusuario;
		}

		public function setMenuId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->rel_menu_id = $valor;
		}

		public function setPerfilUsuario($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->rel_perfilusuario = $valor;
		}
	}
?>