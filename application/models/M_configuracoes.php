<?php
class M_configuracoes extends CI_Model{
    private $configuracao_id;
    private $usuario_id;
    private $titulo;
    private $img_cabecalho;
    private $img_projeto;
    private $cor_predominante;

    	function geral(){
    		$this->db->select('configuracoes.*');

            $this->db->from('configuracoes');
            
            $this->db->where(array('configuracao_id' => 1));
            return $this->db->get();
    	}
	
        function pesquisar($usuario) {
            $this->db->select('configuracoes.*');

            $this->db->from('configuracoes');
            
            $this->db->where(array('usuario_id' => $usuario));
            return $this->db->get();
        }

        function selecionar($codigo) {
            $this->db->where("configuracao_id", $codigo);
            return $this->db->get('configuracoes');
        }

        function selByUser($codigo) {
            $this->db->where("usuario_id", $codigo);
            return $this->db->get('configuracoes');
        }

		function salvar() {
            $arrayCampos  = array(
                "usuario_id"					=> $this->usuario_id,
                "titulo" 						=> $this->titulo,
                "img_cabecalho" 				=> $this->img_cabecalho,
                "img_projeto" 					=> $this->img_projeto,
                "cor_predominante" 				=> $this->cor_predominante,
            );
			if ($this->configuracao_id == ""){
	            $this->db->insert('configuracoes', $arrayCampos);
		        return "inc";
			}
        	else{
	            $this->db->update('configuracoes', $arrayCampos, array("configuracao_id"=>$this->configuracao_id));
		        return "alt";
        	}
		}
		
		function excluir() {
            $arrayCampos  = array(
                "configuracao_id" => $this->configuracao_id                
            );
            if ($this->db->delete('configuracoes', $arrayCampos))
	            return true;
	        else
	        	return false;
		}

        function numeroLinhasTotais($select='', $where=array()) {
            $this->db->where($where);
            $this->db->from('configuracoes');
            return $this->db->count_all_results();
        }
	
// Getters and Setters 
	    public function setConfiguracaoId($valor){
            $this->configuracao_id = $valor;
        }

        public function setUsuarioId($valor){
            $this->usuario_id = $valor;
        }

        public function setTitulo($valor){
            $this->titulo = $valor;
        }

        public function setImgCabecalho($valor){
            $this->img_cabecalho = $valor;
        }

        public function setImgProjeto($valor){
            $this->img_projeto = $valor;
        }

        public function setCorPredominante($valor){
            $this->cor_predominante = $valor;
        }
		
	}
?>