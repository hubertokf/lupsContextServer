<?php
class M_configuracoes extends CI_Model{
    private $configuracao_id;
    private $name;
    private $value;
	
        function pesquisar($where=array()) {
            $this->db->select('configuracoes.*');

            $this->db->from('configuracoes');
            
            $this->db->where($where);
            return $this->db->get();
        }

        function selecionar($codigo) {
            $this->db->where("name", $codigo);
            return $this->db->get('configuracoes');
        }

		function salvar() {
            $arrayCampos  = array(
                "name"			=> $this->name,
                "value"         => $this->value
            );
            $this->db->update('configuracoes', $arrayCampos, array("name"=>$this->name));
	        return "alt";
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

        public function setName($valor){
            $this->name = $valor;
        }

        public function setValue($valor){
            $this->value = $valor;
        }
	}
?>