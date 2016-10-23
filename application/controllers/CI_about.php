<?php
class CI_about extends CI_Controller {
	
	public function __construct()
   {
        parent::__construct();
        
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
        $this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
		$this->M_geral->verificaSessao();
		if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != "")
			$this->dados['isLoged'] = true;
		else
			$this->dados['isLoged'] = false;
   }
 
	function index()
	{	
		if ($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["website_titulo"] != ""){
			$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["website_titulo"];				
		}else{
			$this->dados['title'] = $this->M_configuracoes->selecionar('titulo')->result_array()[0]["value"];
		}
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('about');
		$this->load->view('inc/rodape');
	}
}
?>