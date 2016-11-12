<?php
class M_conditions extends CI_Model{

        public function get_conditions_SB($value='')
        {
          $this->db->select('s.nome as nome');
          $this->db->select('s.sensor_id as id_sensor');
          $this->db->select('s.uuid as uuid');
          $this->db->select('b.url as url');
          $this->db->select('t.nome as tipo');
          $this->db->join('servidoresborda as b','s.servidorborda_id = b.servidorborda_id');
          $this->db->join('tipossensores as t','s.tiposensor_id = t.tiposensor_id','inner');
          $this->db->from('sensores as s');
          $respost = $this->db->get()->result_array();
          return $respost;
        }
        public function get_conditions_CS($value='')
        {
          $this->db->select('s.nome as nome');
          $this->db->select('s.sensor_id as sensor_id');
          $this->db->select('s.uuid as uuid');
          $this->db->select('b.url as url');
          $this->db->select('t.nome as tipo');
          $this->db->join('servidoresborda as b','s.servidorborda_id = b.servidorborda_id');
          $this->db->join('tipossensores as t','s.tiposensor_id = t.tiposensor_id','inner');
          $this->db->from('sensores as s');
          $respost = $this->db->get()->result_array();
          return $respost;

        }
	}
?>
