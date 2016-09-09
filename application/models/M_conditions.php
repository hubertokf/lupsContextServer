<?php
class M_conditions extends CI_Model{

        public function get_conditions_SB($value='')
        {
          $this->db->select('*');
          $this->db->from('condicoes');
          $this->db->where('tipo_server = 1');
          $respost = $this->db->get()->result_array();
          return $respost;
        }

	}
?>
