<?php
	class M_fabricantes extends CI_Model{
	    private $fabricante_id;
	    private $fabricante_nome;
	    private $fabricante_endereco;
	    private $fabricante_telefone;
	    private $fabricante_url;
	    private $fabricante_cidade;
	    private $fabricante_estado;
	    private $fabricante_pais;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->from('fabricantes');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("fabricante_id", $codigo);
            return $this->db->get('fabricantes');
        }
		function salvar() {
            $arrayCampos  = array(
                "nome" 		=> $this->fabricante_nome,
                "endereco" 	=> $this->fabricante_endereco,
                "telefone" 	=> $this->fabricante_telefone,
                "url" 		=> $this->fabricante_url,
                "cidade" 	=> $this->fabricante_cidade,
                "estado"	=> $this->fabricante_estado,
                "pais"	=> $this->fabricante_pais
            );
			if ($this->fabricante_id == ""){
	            $this->db->insert('fabricantes', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('fabricantes', $arrayCampos, array("fabricante_id"=>$this->fabricante_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "fabricante_id" => $this->fabricante_id                
            );
            if ($this->db->delete('fabricantes', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('fabricantes');
            return $this->db->count_all_results();
        }
	
		// Getters and Setters 
	
		public function getFabricanteId(){
			if($this->fabricante_id === NULL) {
				$this->fabricante_id = new FabricanteId;
			}
			return $this->fabricante_id;
		}
		
		public function getFabricanteNome() {
		    if($this->fabricante_nome === NULL) {
        		$this->fabricante_nome = new FabricanteNome;
    		}			
			return $this->fabricante_nome;
		}
		
		public function getFabricanteEndereco() {
		    if($this->fabricante_endereco === NULL) {
        		$this->fabricante_endereco = new FabricanteEndereco;
    		}			
			return $this->fabricante_endereco;
		}
		
		public function getFabricanteTelefone() {
		    if($this->fabricante_telefone === NULL) {
        		$this->fabricante_telefone = new FabricanteTelefone;
    		}			
			return $this->fabricante_telefone;
		}
		
		public function getFabricanteUrl() {
		    if($this->fabricante_url === NULL) {
        		$this->fabricante_url = new FabricanteUrl;
    		}			
			return $this->fabricante_url;
		}

		public function getFabricanteCidade() {
		    if($this->fabricante_cidade === NULL) {
        		$this->fabricante_cidade = new FabricanteCidade;
    		}			
			return $this->fabricante_cidade;
		}

		public function getFabricanteEstado() {
		    if($this->fabricante_estado === NULL) {
        		$this->fabricante_estado = new FabricanteEstado;
    		}			
			return $this->fabricante_estado;
		}

		public function getFabricantePais() {
		    if($this->fabricante_pais === NULL) {
        		$this->fabricante_pais = new FabricanteEstado;
    		}			
			return $this->fabricante_pais;
		}
		
		
		public function setFabricanteId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_id = $valor;
		}
		
		public function setFabricanteNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_nome = $valor;
		}
		
		public function setFabricanteEndereco($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_endereco = $valor;
		}
		
		public function setFabricanteTelefone($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_telefone = $valor;
		}
		
		public function setFabricanteUrl($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_url = $valor;
		}

		public function setFabricanteCidade($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_cidade = $valor;
		}

		public function setFabricanteEstado($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_estado = $valor;
		}

		public function setFabricantePais($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->fabricante_pais = $valor;
		}
		
	}
?>