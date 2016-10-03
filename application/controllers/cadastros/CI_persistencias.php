<?php
class CI_persistencias extends CI_controller {

	public function __construct()
	{
		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		    die();
		}
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_persistencias');
		
	}
	
	function verificaPersistencias(){
		$persistencias = $this->M_persistencias->pesquisar('', array(), '', 0, 'asc');
		
		foreach ($persistencias->result_array() as $persistencia) {
			
			$return = $this->persistir($persistencia);

			if ($return == TRUE){//mudar comparação
				$this->M_persistencias->setPersistenciaId($persistencia['persistencia_id']);	
				$this->M_menus->excluir();
			}else{
				$this->M_persistencias->setPersistenciaId($persistencia['persistencia_id']);
				$this->M_persistencias->setPersistenciaMetodo($persistencia['metodo']);
				$this->M_persistencias->setPersistenciaUrlDestino($persistencia['url_destino']);
				$this->M_persistencias->setPersistenciaToken($persistencia['token']);
				$this->M_persistencias->setPersistenciaDado($persistencia['dado']);
				$this->M_persistencias->setPersistenciaCriacao($persistencia['criacao']);
				$this->M_persistencias->setPersistenciaUltimaTentativa(date('Y-m-d H:i:s'));

				$this->M_persistencias->salvar();
			}
		}
	}

	function persistir($persistencia){

		$curl  = curl_init($persistencia['url_destino']);

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $persistencia['metodo']);
		$data_string = $persistencia['dado'];
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			 	'Authorization: token '.$persistencia['token'],
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
		);
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);

		curl_close($curl);

		if ($info['http_code'] == 200)
			return TRUE;
		else
			return FALSE;
	}

}
?>