<?php
class CI_inicio extends CI_Controller {
	
		public function __construct()
       {
            parent::__construct();
            
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_usuarios');
            $this->load->model('M_usuarios');
			$this->M_geral->verificaSessao();
			if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
       }
 
	function index()
	{	
		if (isset($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"])){
			$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];				
		}else{
			$this->dados['title'] = $this->M_configuracoes->selecionar('titulo')->result_array()[0]["value"];
		}
		$this->dados['usuario_logado'] = $this->session->userdata('nome');
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('saudacao');
		$this->load->view('inc/rodape');
	}
}
?>