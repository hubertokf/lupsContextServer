<?php
class M_agendamentos extends CI_Model{
    private $agendamento_id;
	private $agendamento_desc;
	private $agendamento_ambiente;
	private $agendamento_datetimeinicial;
	private $agendamento_datetimefinal;
	private $agendamento_usuario;
	
    function pesquisar($select='', $where=array(), $limit=10, $offset=0, $ordem='desc', $orderBy='datetimeinicial') {
        $this->db->select('ag.*');

        $this->db->select('a.nome as nome_ambiente');
		$this->db->select('u.nome as nome_usuario');
		
        $this->db->from('agendamentos as ag');

        $this->db->join('ambientes as a','a.ambiente_id = ag.ambiente_id', 'left');
		$this->db->join('usuarios as u','u.usuario_id = ag.usuario_id', 'left');

        $this->db->where($where);
        $this->db->order_by($orderBy,$ordem);
   	    $this->db->limit($limit, $offset);

   	    $query = $this->db->get()->result_array();

   	    foreach($query as $i=>$agendamento) {
   	    	$this->db->select('sensor_id, nome');
        	$this->db->from('sensores as s');
			$this->db->where('s.ambiente_id', $agendamento['ambiente_id']);
			$sensor_query = $this->db->get()->result_array();

		   	$query[$i]['sensores'] = $sensor_query;
		}

        return $query;
    }
	
	function buscaEventos($codigos){
      	$this->db->select('ag.*');
        $this->db->select('e.nome as nome_ambiente');
		$this->db->select('u.nome as nome_usuario');

        $this->db->from('agendamentos as ag');

        $this->db->join('ambientes as e','e.ambiente_id = ag.ambiente_id');
		$this->db->join('usuarios as u','u.usuario_id = ag.usuario_id');

        $this->db->where_in('agendamento_id',$codigos);
        $this->db->order_by('datetimeinicial','asc');
        return $this->db->get();
  	}
	
    function selecionar($codigo) {
        $this->db->where("agendamento_id", $codigo);
        return $this->db->get('agendamentos');
    }
	function salvar() {
        $arrayCampos  = array(
            "descricao" 		=> $this->agendamento_desc,
            "ambiente_id"	=> $this->agendamento_ambiente,
            "datetimeinicial"	=> $this->agendamento_datetimeinicial,
            "datetimefinal" 	=> $this->agendamento_datetimefinal,
            "usuario_id" 		=> $this->agendamento_usuario
        );
		if ($this->agendamento_id == ""){
            $this->db->insert('agendamentos', $arrayCampos);
	        return "inc";
		}
    	else{
            $this->db->update('agendamentos', $arrayCampos, array("agendamento_id"=>$this->agendamento_id));
	        return "alt";
    	}
	}
	
	function excluir() {
        $arrayCampos  = array(
            "agendamento_id" => $this->agendamento_id                
        );
        if ($this->db->delete('agendamentos', $arrayCampos))
            return true;
        else
        	return false;
	}

    function numeroLinhasTotais($select='', $where=array()) {
    	$this->db->where($where);
        $this->db->from('agendamentos');
        return $this->db->count_all_results();
    }

    function pesquisarIntervalosDentro($select='',$idAgendamento, $inicio_interval, $fim_interval, $ambiente) {
    	// do inicio para dentro
    	$this->db->where('ambiente_id =', $ambiente);
    	$this->db->where('datetimeinicial >=' , $inicio_interval);
    	$this->db->where('datetimeinicial <=', $fim_interval);
		$this->db->where('agendamento_id <>', $idAgendamento);
    	$this->db->from('agendamentos');
    	return $this->db->count_all_results();
    }

    function pesquisarIntervalosservidorbordaEsquerda($select='',$idAgendamento, $inicio_interval, $ambiente) {
    	//
    	$this->db->where('ambiente_id =', $ambiente);
    	$this->db->where('datetimeinicial <=' , $inicio_interval);
    	$this->db->where('datetimefinal >=', $inicio_interval);
		$this->db->where('agendamento_id <>', $idAgendamento);
    	$this->db->from('agendamentos');
    	return $this->db->count_all_results();
    }

    function pesquisarIntervalosservidorbordaDireita($select='',$idAgendamento, $fim_interval, $ambiente) {
    	//
    	$this->db->where('ambiente_id =', $ambiente);
    	$this->db->where('datetimeinicial <=' , $fim_interval);
    	$this->db->where('datetimefinal >=', $fim_interval);
		$this->db->where('agendamento_id <>', $idAgendamento);
    	$this->db->from('agendamentos');
    	return $this->db->count_all_results();
    }

    function pesquisarIntervalosFora($select='',$idAgendamento, $inicio_interval, $fim_interval, $ambiente) {
    	// do inicio para dentro
    	$this->db->where('ambiente_id =', $ambiente);
    	$this->db->where('datetimeinicial <=' , $inicio_interval);
    	$this->db->where('datetimeinicial >=', $fim_interval);
		$this->db->where('agendamento_id <>', $idAgendamento);
    	$this->db->from('agendamentos');
    	return $this->db->count_all_results();
    }

// Getters and Setters 
	
	public function getAgendamentoId(){
		if($this->agendamento_id === NULL) {
			$this->agendamento_id = new AgendamentoId;
		}
		return $this->agendamento_id;
	}

	public function getAgendamentoDesc(){
		if($this->agendamento_desc === NULL) {
			$this->agendamento_desc = new AgendamentoDesc;
		}
		return $this->agendamento_desc;
	}

	public function getAgendamentoAmbiente(){
		if($this->agendamento_ambiente === NULL) {
			$this->agendamento_ambiente = new AgendamentoAmbiente;
		}
		return $this->agendamento_ambiente;
	}

	public function getAgendamentoUsuario(){
		if($this->agendamento_usuario === NULL) {
			$this->agendamento_usuario = new AgendamentoUsuario;
		}
		return $this->agendamento_usuario;
	}

	public function getAgendamentoDateTimeInicial(){
		if($this->agendamento_datetimeinicial === NULL) {
			$this->agendamento_datetimeinicial = new AgendamentoDateTimeInicial;
		}
		return $this->agendamento_datetimeinicial;
	}
	
	public function getAgendamentoDateTimeFinal(){
		if($this->agendamento_datetimefinal === NULL) {
			$this->agendamento_datetimefinal = new AgendamentoDateTimeFinal;
		}
		return $this->agendamento_datetimefinal;
	}
        
        public function getSensorList(){
            $this->db->select("sensor.sensor_id");
            $this->db->from("sensores");
            $this->db->where("ambiente_id",  $this->agendamento_ambiente);

            return $this->db->get();
        }
        
        

	public function setAgendamentoId($valor){
		if(!is_string($valor)) {
			throw new InvalidArgumentException('Expected String');
		}
		$this->agendamento_id = $valor;
	}
	
	public function setAgendamentoDesc($valor){
		if(!is_string($valor)) {
			throw new InvalidArgumentException('Expected String');
		}
		$this->agendamento_desc = $valor;
	}

	public function setAgendamentoAmbiente($valor){
		if(!is_string($valor)) {
			throw new InvalidArgumentException('Expected String');
		}
		$this->agendamento_ambiente = $valor;
	}

	public function setAgendamentoUsuario($valor){
		if(!is_string($valor)) {
			throw new InvalidArgumentException('Expected String');
		}
		$this->agendamento_usuario = $valor;
	}

	public function setAgendamentoDateTimeInicial($valor){
		if(!is_string($valor)) {
			throw new InvalidArgumentException('Expected String');
		}
		$this->agendamento_datetimeinicial = $valor;
	}
	
	public function setAgendamentoDateTimeFinal($valor){
		if(!is_string($valor)) {
			throw new InvalidArgumentException('Expected String');
		}
		$this->agendamento_datetimefinal = $valor;
	}

}
?>