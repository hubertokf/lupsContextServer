<?php
class M_actions extends CI_Model{

  public function get_acoes_SB($value='')
  {
    $this->db->select('*');
    $this->db->from('acoes');
    $this->db->where('tipo_server = 1');
    $respost = $this->db->get()->result_array();
    //  echo "<br>";
    return $respost;
  }

  public function get_acoes_CS($value='')
  {
    $this->db->select('*');
    $this->db->from('acoes');
    $this->db->where('tipo_server = 2');
    $respost = $this->db->get()->result_array();
    //  echo "<br>";
    return $respost;
  }


	}
?>
