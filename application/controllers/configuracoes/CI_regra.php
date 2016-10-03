<?php
class CI_regra extends CI_controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_regra');
		$this->load->model('M_usuarios');
		$this->M_geral->verificaSessao();
		if (isset($this->M_configuracoes->selByUser($this->session->userdata('usuario_id'))->result_array()[0]["titulo"]))
			$this->dados['title'] = $this->M_configuracoes->selByUser($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];
		else
			$this->dados['title'] = $title = $this->M_configuracoes->selecionar(1)->result_array()[0]["titulo"];
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
		$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
	}

	function index()
	{	
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('configuracao/regra/pesquisa');
		$this->load->view('inc/rodape');
	}
	
	function interna(){
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('configuracao/regra/interna');
		$this->load->view('inc/rodape');		
	}
	
	function externa(){
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('configuracao/regra/externa');
		$this->load->view('inc/rodape');	
	}
	
	function doku(){
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('inc/menu');
		$this->load->view('configuracao/regra/doku/install');
		$this->load->view('inc/rodape');
	}
}
?>