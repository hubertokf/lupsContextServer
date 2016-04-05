<?php
class M_permissoes extends CI_Model {
	private $permissao_id;
	private $usuario_id;
    private $contextointeresse_id;
    private $sensor_id;
    private $ambiente_id;
	private $regra_id;
    private $podeeditar;
    private $recebeemail;

    function pesquisar($select='', $where=array(), $limit=10000, $offset=0, $orderby='usuario_nome', $ordem='asc') {
        $this->db->select('permissoes.*');

        $this->db->select('u.nome as usuario_nome');
        $this->db->select('ci.nome as contextointeresse_nome');
        $this->db->select('s.nome as sensor_nome');
        $this->db->select('a.nome as ambiente_nome');
        $this->db->select('r.nome as regra_nome');          

        $this->db->from('permissoes');

        $this->db->join('usuario as u', 'permissoes.usuario_id = u.usuario_id', 'left');
        $this->db->join('contextointeresse as ci', 'permissoes.contextointeresse_id = ci.contextointeresse_id', 'left');
        $this->db->join('sensor as s', 'permissoes.sensor_id = s.sensor_id', 'left');
        $this->db->join('ambiente as a','permissoes.ambiente_id = a.ambiente_id', 'left');
        $this->db->join('regras as r','permissoes.regra_id = r.regra_id', 'left');

        $this->db->where($where);
        $this->db->order_by($orderby,$ordem);
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
		
    function selecionar($id) {
        $this->db->where("permissao_id", $id);
        return $this->db->get('permissoes')->result_array();
    }
	function salvar() {
        $arrayCampos  = array(
            "usuario_id"            => $this->usuario_id,
            "contextointeresse_id"  => $this->contextointeresse_id,
            "sensor_id"             => $this->sensor_id,
            "ambiente_id" 			=> $this->ambiente_id,
            "regra_id" 	            => $this->regra_id,
            "podeeditar"            => $this->podeeditar,
            "recebeemail"           => $this->recebeemail
        );

        $this->db->insert('permissoes', $arrayCampos);
        return "inc";
	}

	function excluir() {
        $arrayCampos  = array(
            "permissao_id" => $this->permissao_id                
        );
        if ($this->db->delete('permissoes', $arrayCampos)){
            if ($this->db->delete('permissoes', $arrayCampos))
	            return true;
	        else
	        	return false;
	    }
	}

    function numeroLinhasTotais($select='', $where=array()) {
        $this->db->where($where);
        $this->db->from('permissoes');
        return $this->db->count_all_results();
    }
            
    // Getters and Setters 
    public function getPermissaoId(){
        if($this->permissao_id === NULL) {
            $this->permissao_id = new PermissaoId;
        }
        return $this->permissao_id;
    }

    public function getPermissaoUsuario(){
        if($this->usuario_id === NULL) {
            $this->usuario_id = new PermissaoUsuario;
        }
        return $this->usuario_id;
    }

    public function getPermissaoContextoInteresse(){
        if($this->contextointeresse_id === NULL) {
            $this->contextointeresse_id = new PermissaoContextoInteresse;
        }
        return $this->contextointeresse_id;
    }

    public function getPermissaoSensor(){
        if($this->sensor_id === NULL) {
            $this->sensor_id = new PermissaoSensor;
        }
        return $this->sensor_id;
    }

    public function getPermissaoAmbiente(){
        if($this->ambiente_id === NULL) {
            $this->ambiente_id = new PermissaoAmbiente;
        }
        return $this->ambiente_id;
    }

    public function getPermissaoRegra(){
        if($this->regra_id === NULL) {
            $this->regra_id = new PermissaoRegra;
        }
        return $this->regra_id;
    }

    public function getPermissaoPodeeditar(){
        if($this->podeeditar === NULL) {
            $this->podeeditar = new PermissaoPodeeditar;
        }
        return $this->podeeditar;
    }

    public function getPermissaoRecebeemail(){
        if($this->recebeemail === NULL) {
            $this->recebeemail = new PermissaoRecebeemail;
        }
        return $this->recebeemail;
    }

    public function setPermissaoId($valor){
        $this->permissao_id = $valor;
    }

    public function setPermissaoUsuario($valor){
        $this->usuario_id = $valor;
    }

    public function setPermissaoContextoInteresse($valor){
        $this->contextointeresse_id = $valor;
    }

    public function setPermissaoSensor($valor){
        $this->sensor_id = $valor;
    }

    public function setPermissaoAmbiente($valor){
        $this->ambiente_id = $valor;
    }

    public function setPermissaoRegra($valor){
        $this->regra_id = $valor;
    }

    public function setPermissaoPodeeditar($valor){
        $this->podeeditar = $valor;
    }

    public function setPermissaoRecebeemail($valor){
        $this->recebeemail = $valor;
    }
}
?>