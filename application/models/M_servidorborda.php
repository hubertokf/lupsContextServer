<?php
class M_servidorborda extends CI_Model{
    private $servidorborda_id;
    private $servidorborda_nome;
    private $servidorborda_desc;
    private $servidorborda_latitude;
    private $servidorborda_longitude;
    private $servidorborda_contexto;
    private $servidorborda_url;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->select('servidorborda.*');
            $this->db->select('c.nome as contexto_nome');

            $this->db->from('servidorborda');

            $this->db->join('servidorcontexto as c', 'servidorborda.servidorcontexto_id = c.servidorcontexto_id', 'left');

            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("servidorborda_id", $codigo);
            return $this->db->get('servidorborda');
        }
		function salvar() {
            $arrayCampos  = array(
            	"nome" 			=> $this->servidorborda_nome,
                "descricao" 	=> $this->servidorborda_desc,
                "latitude" 		=> $this->servidorborda_latitude,
                "longitude" 	=> $this->servidorborda_longitude,
                "servidorcontexto_id" 	=> $this->servidorborda_contexto,
                "access_token" 			=> $this->servidorborda_access_token,
                "url"					=> $this->servidorborda_url
            );
			if ($this->servidorborda_id == ""){
	            $this->db->insert('servidorborda', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('servidorborda', $arrayCampos, array("servidorborda_id"=>$this->servidorborda_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "servidorborda_id" => $this->servidorborda_id                
            );
            if ($this->db->delete('servidorborda', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('servidorborda');
            return $this->db->count_all_results();
        }
	
// Getters and Setters 
	
		public function getservidorbordaId(){
			if($this->servidorborda_id === NULL) {
				$this->servidorborda_id = new servidorbordaId;
			}
			return $this->servidorborda_id;
		}

		public function getservidorbordaNome() {
		    if($this->servidorborda_nome === NULL) {
        		$this->servidorborda_nome = new servidorbordaNome;
    		}			
			return $this->servidorborda_nome;
		}
		
		public function getservidorbordaDesc() {
		    if($this->servidorborda_desc === NULL) {
        		$this->servidorborda_desc = new servidorbordaDesc;
    		}			
			return $this->servidorborda_desc;
		}

		public function getservidorbordaLatitude(){
			if($this->servidorborda_latitude === NULL) {
				$this->servidorborda_latitude = new servidorbordaLatitude;
			}
			return $this->servidorborda_latitude;
		}
		
		public function getservidorbordaLongitude() {
		    if($this->servidorborda_longitude === NULL) {
        		$this->servidorborda_longitude = new servidorbordaLongitude;
    		}			
			return $this->servidorborda_longitude;
		}

		public function getservidorbordaContexto(){
			if($this->servidorborda_contexto === NULL) {
				$this->servidorborda_contexto = new servidorbordaContexto;
			}
			return $this->servidorborda_contexto;
		}	

		public function getservidorbordaUrl(){
			if($this->servidorborda_url === NULL) {
				$this->servidorborda_url = new servidorbordaUrl;
			}
			return $this->servidorborda_url;
		}

		public function getservidorbordaAccessToken(){
			if($this->servidorborda_access_token === NULL) {
				$this->servidorborda_access_token = new servidorbordaAccessToken;
			}
			return $this->servidorborda_access_token;
		}
		
		public function setservidorbordaId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_id = $valor;
		}
		
		public function setservidorbordaNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_nome = $valor;
		}

		public function setservidorbordaDesc($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_desc = $valor;
		}
		
		public function setservidorbordaLatitude($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_latitude = $valor;
		}

		public function setservidorbordaLongitude($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_longitude = $valor;
		}
		
		public function setservidorbordaContexto($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_contexto = $valor;
		}

		public function setservidorbordaAccessToken($valor){
			$this->servidorborda_access_token = $valor;
		}

		public function setservidorbordaUrl($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->servidorborda_url = $valor;
		}
		
	}
?>