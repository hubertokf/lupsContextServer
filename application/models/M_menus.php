<?php
class M_menus extends CI_Model {
	private $menu_id;
	private $menu_nome;
	private $menu_parente;
	private $menu_caminho;
	private $menu_ordem;
		
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select('menus.*');
            
            $this->db->from('menus');

            $this->db->where($where);
            $this->db->order_by('ordem',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
		function pesquisarParentes() {
			$this->db->select("menus.*");
			$this->db->from('menus');
			$this->db->where(array('parente' => NULL));
			$this->db->or_where(array('parente' => ""));
			$this->db->order_by('menu_id', 'asc');
			return $this->db->get();
		}
		
		function buscarSubmenus($id) {
			$this->db->select("menus.*");
			$this->db->from('menus');
			$this->db->where(array('parente' => $id));
			$this->db->order_by('menu_id', 'asc');
			return $this->db->get();
		}

        function selecionar($codigo) {
            $this->db->where("menu_id", $codigo);
            return $this->db->get('menus');
        }
		function salvar() {
            $arrayCampos  = array(
                "nome" 			=> $this->menu_nome,
                "parente" 		=> $this->menu_parente,
                "caminho" 		=> $this->menu_caminho,
				"ordem"			=> $this->menu_ordem	
            );

			if ($this->menu_id == ""){
	            $this->db->insert('menus', $arrayCampos);

	            $insert_id = $this->db->insert_id();

	            $arrayCampos2  = array(
	                "menu_id" 			=> $insert_id,
	                "perfilusuario_id"	=> '1'
            	);
	            $this->db->insert('relmenuperfil', $arrayCampos2);
		        return "inc";
			}
        	else{
	            $this->db->update('menus', $arrayCampos, array("menu_id"=>$this->menu_id));
		        return "alt";
        	}
		}

		function excluir() {
            $arrayCampos  = array(
                "menu_id" => $this->menu_id                
            );
            if ($this->db->delete('relmenuperfil', $arrayCampos)){
	            if ($this->db->delete('menus', $arrayCampos))
		            return true;
		        else
		        	return false;
		    }
		}

        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('menus');
            return $this->db->count_all_results();
        }

		function contarMenus ($perfil, $menu) {
			$where = array("menu_id"=>$menu);
			if($perfil != NULL)
				$where = array("perfilusuario_id"=>$perfil,"menu_id"=>$menu);
        	$this->db->where($where);
            $this->db->from('relmenuperfil');
            return $this->db->count_all_results();
		}
			
// Getters and Setters 

		public function getMenuId(){
			if($this->menu_id === NULL) {
				$this->menu_id = new MenuId;
			}
			return $this->menu_id;
		}

		public function getMenuNome() {
		    if($this->menu_nome === NULL) {
        		$this->menu_nome = new MenuNome;
    		}			
			return $this->menu_nome;
		}

		public function getMenuParente() {
		    if($this->menu_parente === NULL) {
        		$this->menu_parente = new MenuParente;
    		}			
			return $this->menu_parente;
		}

		public function getMenuCaminho() {
			if($this->menu_caminho === NULL) {
				$this->menu_caminho = new MenuCaminho;
			}
			return $this->menu_caminho;
		}

		public function getMenuOrdem() {
		    if($this->menu_ordem === NULL) {
        		$this->menu_ordem = new MenuOrdem;
    		}			
			return $this->menu_ordem;
		}
		
		public function setMenuId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->menu_id = $valor;
		}

		public function setMenuNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->menu_nome = $valor;
		}

		public function setMenuParente($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->menu_parente = $valor;
		}

		public function setMenuCaminho($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->menu_caminho = $valor;
		}
		
		public function setMenuOrdem($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->menu_ordem = $valor;
		}
	}
?>