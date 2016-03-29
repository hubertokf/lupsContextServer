<?php
class M_relcontextointeresse extends CI_Model {
	private $sensor_id;
	private $contextointeresse_id;
	private $regra_id;
		
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

        $this->db->join('sensor as s', 's.sensor_id = relcontextointeresse.sensor_id', 'left');

        $this->db->where("contextointeresse_id", $codigo);
        return $this->db->get()->result_array();
    }
}
			
// Getters and Setters 
?>