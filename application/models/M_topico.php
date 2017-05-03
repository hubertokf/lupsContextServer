<?php
class M_topico extends CI_Model{
    private $topico_id;
    private $topico_nome;

    public function set_nome_topico($value_topico=''){
        $this->topico_nome = $value_topico;
    }

    public function salvar(){
        $campo_array = array('nome' => $this->topico_nome);
        $this->db->insert('topicos',$campo_array);
    }

    public function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='asc') {
        $this->db->select($select);
        $this->db->select('t.*');
        $this->db->from('topicos as t');
        $this->db->where($where);
        $this->db->order_by('nome',$ordem);
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    function numeroLinhasTotais($select='', $where=array()) {
        $this->db->where($where);
        $this->db->from('topicos');
        return $this->db->count_all_results();
    }


	}
?>
