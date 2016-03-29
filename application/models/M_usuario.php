<?php
	class M_usuario extends CI_Model{
	    private $usuario_id;
		private $usuario_nome;
		private $usuario_perfil;
		private $usuario_username;
		private $usuario_password;
		private $usuario_email;
		private $usuario_telefone;
		private $usuario_celular;
		  
        function __construct() {
        	parent::__construct();
        }

        function logar($username="", $password="") {
        	$this->db->select('*');
			$this->db->from('usuario');
        	$this->db->where('usuario.username', $username);
        	$this->db->where('usuario.password', $password);
        	return $this->db->get();
        }

        function getPerfilByUsuarioID($codigo){
        	$this->db->select('perfilusuario_id');
			$this->db->from('usuario');
        	$this->db->where("usuario_id", $codigo);
            return $this->db->get()->result();
        }
	
        function pesquisar($select='', $where=array(), $limit="", $offset=0, $ordem='asc') {
            $this->db->select('usuario.*');
			$this->db->select('pu.nome as nome_perfil');
            $this->db->from('usuario');
			$this->db->join('perfilusuario as pu','usuario.perfilusuario_id = pu.perfilusuario_id', 'left');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("usuario_id", $codigo);
            return $this->db->get('usuario');
        }
		function salvar() {
            $arrayCampos  = array(
                "nome"	 				=> $this->usuario_nome,
                "username" 				=> $this->usuario_username,
				"perfilusuario_id"		=> $this->usuario_perfil,				
                "password" 				=> $this->usuario_password,
                "email" 				=> $this->usuario_email,						
                "telefone" 				=> $this->usuario_telefone,						
                "celular"				=> $this->usuario_celular						
            );
			if ($this->usuario_id == ""){
	            $this->db->insert('usuario', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('usuario', $arrayCampos, array("usuario_id"=>$this->usuario_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "usuario_id" => $this->usuario_id                
            );
            if ($this->db->delete('usuario', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('usuario');
            return $this->db->count_all_results();
        }
	
		// Getters and Setters 
	
		public function getUsuarioId(){
			if($this->usuario_id === NULL) {
				$this->usuario_id = new UsuarioId;
			}
			return $this->usuario_id;
		}
	
		public function getUsuarioPerfil(){
			if($this->usuario_perfil === NULL) {
				$this->usuario_perfil = new UsuarioPerfil;
			}
			return $this->usuario_perfil;
		}
		
		public function getUsuarioNome(){
			if($this->usuario_nome === NULL) {
				$this->usuario_nome = new UsuarioNome;
			}
			return $this->usuario_nome;
		}
		
		public function getUsuarioUsername(){
			if($this->usuario_username === NULL) {
				$this->usuario_username = new UsuarioUsername;
			}
			return $this->usuario_username;
		}
	
		public function getUsuarioPassword(){
			if($this->usuario_password === NULL) {
				$this->usuario_password = new UsuarioPassword;
			}
			return $this->usuario_password;
		}

		public function getUsuarioEmail(){
			if($this->usuario_email === NULL) {
				$this->usuario_email = new UsuarioEmail;
			}
			return $this->usuario_email;
		}

		public function getUsuarioTelefone(){
			if($this->usuario_telefone === NULL) {
				$this->usuario_telefone = new UsuarioTelefone;
			}
			return $this->usuario_telefone;
		}

		public function getUsuarioCelular(){
			if($this->usuario_celular === NULL) {
				$this->usuario_celular = new UsuarioCelular;
			}
			return $this->usuario_celular;
		}

		public function setUsuarioId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_id = $valor;
		}

		public function setUsuarioPerfil($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_perfil = $valor;
		}

		public function setUsuarioUsername($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_username = $valor;
		}

		public function setUsuarioNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_nome = $valor;
		}

		public function setUsuarioPassword($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_password = $valor;
		}
		
		public function setUsuarioEmail($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_email = $valor;
		}
		
		public function setUsuarioTelefone($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_telefone = $valor;
		}
		
		public function setUsuarioCelular($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_celular = $valor;
		}

	}

?>