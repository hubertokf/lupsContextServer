<?php
class M_relcontextointeresse extends CI_Model {
	private $sensor_id;
	private $contextointeresse_id;
	// private $regra_id;
		
    function selecionar($codigo) {
        $this->db->where("contextointeresse_id", $codigo);
        return $this->db->get('relcontextointeresse')->result_array();
    }
	function salvar() {
        $arrayCampos  = array(
            "sensor_id" 			=> $this->sensor_id,
            "contextointeresse_id" 	=> $this->contextointeresse_id
        );
		if ($this->sensor_id == ""){
            $this->db->insert('relcontextointeresse', $arrayCampos);
	        return "inc";
		}
    	else{
            $this->db->update('relcontextointeresse', $arrayCampos, array("sensor_id"=>$this->sensor_id));
	        return "alt";
    	}
	}

	function excluir() {
        $arrayCampos  = array(
            "sensor_id" => $this->sensor_id                
        );
        if ($this->db->delete('relcontextointeresse', $arrayCampos)){
            if ($this->db->delete('relcontextointeresse', $arrayCampos))
	            return true;
	        else
	        	return false;
	    }
	}

	function getByCi($codigo) {
		$this->db->select('relcontextointeresse.*');

        $this->db->select('s.nome as sensor_nome');
        
        $this->db->from('relcontextointeresse');

        $this->db->join('sensores as s', 's.sensor_id = relcontextointeresse.sensor_id', 'left');

        $this->db->where("contextointeresse_id", $codigo);
        return $this->db->get()->result_array();
    }

    function getChkByCi($codigo){
        $this->db->select('relcontextointeresse.sensor_id');

        $this->db->select('s.nome as sensor_nome');
        
        $this->db->from('relcontextointeresse');

        $this->db->join('sensores as s', 's.sensor_id = relcontextointeresse.sensor_id', 'left');

        $this->db->where(array("contextointeresse_id"=>$codigo,"ativaregra"=>"TRUE"));
        return $this->db->get()->result_array();
    }

    function getBySensor($codigo){

        $this->db->select('rci.*');
        $this->db->select('r.tipo as regra_tipo');
        $this->db->select('r.arquivo_py as regra_arquivo');
        $this->db->select('r.status as regra_status');
        $this->db->select('r.regra_id as regra_id');
        $this->db->select('r.nome as regra_nome');
        $this->db->select('ci.nome as ci_nome');

        $this->db->from('relcontextointeresse as rci');

        $this->db->join('contextosinteresse as ci', 'ci.contextointeresse_id = rci.contextointeresse_id');
        $this->db->join('regras as r', 'r.regra_id = ci.regra_id', 'left');

        $this->db->where(array("rci.sensor_id"=>$codigo));
        return $this->db->get();
    }
}
			
// Getters and Setters 
?>