<?php
class M_relidregras extends CI_Model {
	private $id_regra_context;
	private $id_regra_edge;
	// private $regra_id;
  public function get_id_regraEgde($value='')
  {
     $this->db->select('id_regra_edge');
  	 $this->db->from('relidregras');
     $this->db->whhere('id_regra_context ='.$value);
		  return $this->db->get();
  }
	public function set_id_edge($value_edge='')
	{
		$this->id_regra_edge = $value_edge;
	}
	public function set_id_context($value_context='')
	{
		$this->id_regra_context = $value_context;
	}
	public function salvar()
	{
		$campo_array  = array('id_regra_context' => $this->id_regra_context,'id_regra_edge' => $this->id_regra_edge );
		$this->db->insert('relidregras',$campo_array);
	}
}

// Getters and Setters
?>
