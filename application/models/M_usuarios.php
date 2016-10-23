<?php
	class M_usuarios extends CI_Model{
	    private $usuario_id;
		private $usuario_nome;
		private $usuario_perfil;
		private $usuario_username;
		private $usuario_password;
		private $usuario_email;
		private $usuario_telefone;
		private $usuario_celular;
		private $usuario_token;
		private $usuario_website_titulo;
		private $usuario_img_cabecalho;
		private $usuario_img_projeto;
		private $usuario_cor_predominante;
		private $usuario_titulo_projeto;
		  
        function __construct() {
        	parent::__construct();
        }

        function logar($username="") {
        	$this->db->select('*');
			$this->db->from('usuarios');
        	$this->db->where('usuarios.username', $username);
        	return $this->db->get();
        }

        function getPerfilByUsuarioID($codigo){
        	$this->db->select('perfilusuario_id');
			$this->db->from('usuarios');
        	$this->db->where("usuario_id", $codigo);
            return $this->db->get()->result();
        }
	
        function pesquisar($select='', $where=array(), $limit="", $offset=0, $ordem='asc') {
            $this->db->select('u.*');
			$this->db->select('pu.nome as nome_perfil');
            $this->db->from('usuarios as u');
			$this->db->join('perfisusuarios as pu','u.perfilusuario_id = pu.perfilusuario_id', 'left');
            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("usuario_id", $codigo);
            return $this->db->get('usuarios');
        }

        function selByPerfilUsuario($codigo) {
            $this->db->where("perfilusuario_id", $codigo);
            return $this->db->get('usuarios');
        }

        function countUsuarioMenu($usuario_id){
        	$this->db->select('rmp.*');
            $this->db->from('usuarios as u');
			$this->db->join('relmenuperfil as rmp','rmp.perfilusuario_id = u.perfilusuario_id');
            $this->db->where(array('u.usuario_id' => $usuario_id));
            return $this->db->count_all_results();
        }

		function salvar() {
			if (isset($this->usuario_password)){
	            $arrayCampos  = array(
	                "nome"	 				=> $this->usuario_nome,
	                "username" 				=> $this->usuario_username,
					"perfilusuario_id"		=> $this->usuario_perfil,				
	                "password" 				=> $this->usuario_password,
	                "email" 				=> $this->usuario_email,						
	                "telefone" 				=> $this->usuario_telefone,						
	                "celular"				=> $this->usuario_celular,
	                "token"					=> $this->usuario_token,
	                "website_titulo"		=> $this->usuario_website_titulo,	
					"img_cabecalho"			=> $this->usuario_img_cabecalho,
					"img_projeto"			=> $this->usuario_img_projeto,	
					"cor_predominante"		=> $this->usuario_cor_predominante,
					"titulo_projeto"		=> $this->usuario_titulo_projeto
	            );				
			}else{
				$arrayCampos  = array(
	                "nome"	 				=> $this->usuario_nome,
	                "username" 				=> $this->usuario_username,
					"perfilusuario_id"		=> $this->usuario_perfil,				
	                "email" 				=> $this->usuario_email,						
	                "telefone" 				=> $this->usuario_telefone,						
	                "celular"				=> $this->usuario_celular,
	                "token"					=> $this->usuario_token,
	                "website_titulo"		=> $this->usuario_website_titulo,	
					"img_cabecalho"			=> $this->usuario_img_cabecalho,
					"img_projeto"			=> $this->usuario_img_projeto,	
					"cor_predominante"		=> $this->usuario_cor_predominante,
					"titulo_projeto"		=> $this->usuario_titulo_projeto
	            );		
			}
			if ($this->usuario_id == ""){
	            $this->db->insert('usuarios', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('usuarios', $arrayCampos, array("usuario_id"=>$this->usuario_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "usuario_id" => $this->usuario_id                
            );
            if ($this->db->delete('usuarios', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('usuarios');
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

		public function getUsuarioToken(){
			if($this->usuario_token === NULL) {
				$this->usuario_token = new UsuarioToken;
			}
			return $this->usuario_token;
		}

		public function getUsuarioWebsiteTitulo(){
			if($this->usuario_website_titulo === NULL) {
				$this->usuario_website_titulo = new UsuarioWebsiteTitulo;
			}
			return $this->usuario_website_titulo;
		}

		public function getUsuarioImgCabecalho(){
			if($this->usuario_img_cabecalho === NULL) {
				$this->usuario_img_cabecalho = new UsuarioImgCabecalho;
			}
			return $this->usuario_img_cabecalho;
		}

		public function getUsuarioImgProjeto(){
			if($this->usuario_img_projeto === NULL) {
				$this->usuario_img_projeto = new UsuarioImgProjeto;
			}
			return $this->usuario_img_projeto;
		}

		public function getUsuarioCorPredominante(){
			if($this->usuario_cor_predominante === NULL) {
				$this->usuario_cor_predominante = new UsuarioCorPredominante;
			}
			return $this->usuario_cor_predominante;
		}

		public function getUsuarioTituloProjeto(){
			if($this->usuario_titulo_projeto === NULL) {
				$this->usuario_titulo_projeto = new UsuarioTituloProjeto;
			}
			return $this->usuario_titulo_projeto;
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

		public function setUsuarioToken($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->usuario_token = $valor;
		}

		public function setUsuarioWebsiteTitulo($valor){
			$this->usuario_website_titulo = $valor;
		}

		public function setUsuarioImgCabecalho($valor){
			$this->usuario_img_cabecalho = $valor;
		}

		public function setUsuarioImgProjeto($valor){
			$this->usuario_img_projeto = $valor;
		}

		public function setUsuarioCorPredominante($valor){
			$this->usuario_cor_predominante = $valor;
		}

		public function setUsuarioTituloProjeto($valor){
			$this->usuario_titulo_projeto = $valor;
		}

	}

?>