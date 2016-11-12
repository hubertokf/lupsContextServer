<?php
	class M_persistencias extends CI_Model{
	    private $persistencia_id;
		private $persistencia_metodo;
		private $persistencia_url_destino;
		private $persistencia_token;
		private $persistencia_dado;
		private $persistencia_criacao;
		private $persistencia_email;
		private $persistencia_ultimatentativa;
		  
        function __construct() {
        	parent::__construct();
        }
	
        function pesquisar($select='', $where=array(), $limit="", $offset=0, $ordem='asc') {
            $this->db->select('p.*');
            $this->db->from('persistencias as p');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("persistencia_id", $codigo);
            return $this->db->get('persistencias');
        }

		function salvar() {
            $arrayCampos  = array(
                "metodo"	 				=> $this->persistencia_metodo,
                "url_destino" 				=> $this->persistencia_url_destino,
                "token" 				=> $this->persistencia_token,
				"dado"						=> $this->persistencia_dado,
                "ultimatentativa" 			=> $this->persistencia_ultimatentativa				
            );
			if ($this->persistencia_id == ""){
	            $this->db->insert('persistencias', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('persistencias', $arrayCampos, array("persistencias_id"=>$this->persistencia_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "persistencias_id" => $this->persistencia_id                
            );
            if ($this->db->delete('persistencias', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('persistencias');
            return $this->db->count_all_results();
        }
	
		// Getters and Setters 
	
		public function getPersistenciaId(){
			if($this->persistencia_id === NULL) {
				$this->persistencia_id = new PersistenciaId;
			}
			return $this->persistencia_id;
		}
	
		public function getPersistenciaMetodo(){
			if($this->persistencia_metodo === NULL) {
				$this->persistencia_metodo = new PersistenciaMetodo;
			}
			return $this->persistencia_metodo;
		}
		
		public function getPersistenciaUrlDestino(){
			if($this->persistencia_url_destino === NULL) {
				$this->persistencia_url_destino = new PersistenciaUrlDestino;
			}
			return $this->persistencia_url_destino;
		}

		public function getPersistenciaToken(){
			if($this->persistencia_token === NULL) {
				$this->persistencia_token = new PersistenciaToken;
			}
			return $this->persistencia_token;
		}
		
		public function getPersistenciaDado(){
			if($this->persistencia_dado === NULL) {
				$this->persistencia_dado = new PersistenciaDado;
			}
			return $this->persistencia_dado;
		}

		public function getPersistenciaCriacao(){
			if($this->persistencia_criacao === NULL) {
				$this->persistencia_criacao = new PersistenciaCriacao;
			}
			return $this->persistencia_criacao;
		}

		public function getPersistenciaUltimaTentativa(){
			if($this->persistencia_ultimatentativa === NULL) {
				$this->persistencia_ultimatentativa = new PersistenciaUltimaTentativa;
			}
			return $this->persistencia_ultimatentativa;
		}

		public function setPersistenciaId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_id = $valor;
		}

		public function setPersistenciaMetodo($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_metodo = $valor;
		}

		public function setPersistenciaToken($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_token = $valor;
		}

		public function setPersistenciaUrlDestino($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_url_destino = $valor;
		}

		public function setPersistenciaDado($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_dado = $valor;
		}

		public function setPersistenciaCriacao($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_criacao = $valor;
		}
		
		public function setPersistenciaUltimaTentativa($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->persistencia_ultimatentativa = $valor;
		}
	}

?>