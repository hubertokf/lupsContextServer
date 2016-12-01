<?php
class M_gateways extends CI_Model{
    private $gateway_id;
    private $gateway_nome;
    private $gateway_modelo;
    private $gateway_fabricante;
    private $gateway_servidorborda;
    private $gateway_uuid;
    private $gateway_status;
	
        function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
            $this->db->select($select);
            $this->db->select('g.*');
            $this->db->select('f.nome as fabricante_nome');
            $this->db->select('b.nome as servidorborda_nome');

            $this->db->from('gateways as g');

            $this->db->join('fabricantes as f', 'g.fabricante_id = f.fabricante_id', 'left');
            $this->db->join('servidoresborda as b', 'g.servidorborda_id = b.servidorborda_id', 'left');

            $this->db->where($where);
            $this->db->order_by('nome',$ordem);
       	    $this->db->limit($limit, $offset);
            return $this->db->get();
        }
		
        function selecionar($codigo) {
            $this->db->where("gateway_id", $codigo);
            return $this->db->get('gateways');
        }

        function getBySBid($codigo) {
            $this->db->where("servidorborda_id", $codigo);
            return $this->db->get('gateways')->result_array();
        }

        function altStatus() {
        	$arrayCampos  = array(
                "status" 	=> $this->gateway_status
            );
			$this->db->update('gateways', $arrayCampos, array("gateway_id"=>$this->gateway_id));
	        return "alt";
        }

		function salvar() {
            $arrayCampos  = array(
            	"nome" 			=> $this->gateway_nome,
                "modelo" 		=> $this->gateway_modelo,
                "fabricante_id" => $this->gateway_fabricante,
                "servidorborda_id" 		=> $this->gateway_servidorborda,
                "uuid" 		=> $this->gateway_uuid,
                "status" 		=> $this->gateway_status
            );
			if ($this->gateway_id == ""){
	            $this->db->insert('gateways', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('gateways', $arrayCampos, array("gateway_id"=>$this->gateway_id));
		        return "alt";
        	}
		}

		function salvaGateway() {
            $arrayCampos  = array(
            	"nome" 			=> $this->gateway_nome,
                "servidoresborda_id" 		=> $this->gateway_servidorborda,
                "uuid" 					=> $this->gateway_uuid
            );

            if ($this->checkByUID($this->gateway_uid) > 0){
            	$this->db->update('gateways', $arrayCampos, array("uuid"=>$this->gateway_uid));
            	$this->db->where(array("uuid"=>$this->gateway_uuid));
				$insert_id =  $this->db->get('gateway')->row()->gateway_id;

				$publicType = "update";
            }else{
            	$this->db->insert('gateways', $arrayCampos);
            	$insert_id = $this->db->insert_id();

            	$publicType = "insert";
            }

			return  $publicType.":".$insert_id;
		}

		function checkByUID($codigo) {
            $this->db->where("uuid", $codigo);
            $this->db->from('gateways');
            return $this->db->count_all_results();
        }
		
		function excluir() {
            $arrayCampos  = array(
                "gateway_id" => $this->gateway_id                
            );
            if ($this->db->delete('gateways', $arrayCampos))
	            return true;
	        else
	        	return false;
		}
	
        function numeroLinhasTotais($select='', $where=array()) {
        	$this->db->where($where);
            $this->db->from('gateways');
            return $this->db->count_all_results();
        }
	
// Getters and Setters 
	
		public function getGatewayId(){
			if($this->gateway_id === NULL) {
				$this->gateway_id = new GatewayId;
			}
			return $this->gateway_id;
		}

		public function getGatewayNome() {
		    if($this->gateway_nome === NULL) {
        		$this->gateway_nome = new GatewayNome;
    		}			
			return $this->gateway_nome;
		}
		
		public function getGatewayModelo() {
		    if($this->gateway_modelo === NULL) {
        		$this->gateway_modelo = new GatewayModelo;
    		}			
			return $this->gateway_modelo;
		}

		public function getGatewayFabricante(){
			if($this->gateway_fabricante === NULL) {
				$this->gateway_fabricante = new GatewayFabricante;
			}
			return $this->gateway_fabricante;
		}
		
		public function getGatewayservidorborda() {
		    if($this->gateway_servidorborda === NULL) {
        		$this->gateway_servidorborda = new Gatewayservidorborda;
    		}			
			return $this->gateway_servidorborda;
		}

		public function getGatewayUuid() {
		    if($this->gateway_uuid === NULL) {
        		$this->gateway_uuid = new GatewayUID;
    		}			
			return $this->gateway_uuid;
		}

		public function getGatewayStatus() {
		    if($this->gateway_status === NULL) {
        		$this->gateway_status = new GatewayStatus;
    		}			
			return $this->gateway_status;
		}
		
		public function setGatewayStatus($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_status = $valor;
		}
		
		public function setGatewayId($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_id = $valor;
		}
		
		public function setGatewayNome($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_nome = $valor;
		}

		public function setGatewayModelo($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_modelo = $valor;
		}
		
		public function setGatewayFabricante($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_fabricante = $valor;
		}

		public function setGatewayservidorborda($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_servidorborda = $valor;
		}

		public function setGatewayUuid($valor){
			if(!is_string($valor)) {
				throw new InvalidArgumentException('Expected String');
			}
			$this->gateway_uuid = $valor;
		}
		
	}
?>