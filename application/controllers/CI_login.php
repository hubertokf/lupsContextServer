<?php 

class CI_login extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
            $this->load->model('M_usuarios');
	    $this->load->model('M_configuracoes');
			if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else{
				$this->dados['isLoged'] = false;
			}
       }
 
	function index()
	{	
		$str = "abcdefhjk2345678mnpqrstuvwxyz2345678ABCDEFHJKLMN2345678PQRSTUVWXYZ2345678";
		$random_word= str_shuffle($str);
		$random_word= substr($random_word,0,5);		
		$this->dados['captcha']=$random_word;
		if (isset($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"])){
			$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];				
		}else{
			$this->dados['title'] = $this->M_configuracoes->selecionar('titulo')->result_array()[0]["value"];
		}
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('login');
		$this->load->view('inc/copyright');
		
	}
	
	function logar()
	{
		if (isset($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"])){
				$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];				
			}else{
				$this->dados['title'] = $this->M_configuracoes->selecionar('titulo')->result_array()[0]["value"];
			}
		if(!empty($_POST["login"]) && !empty($_POST["password"]) /*&& !empty($_POST["codigo"])*/) {
			//if ($_POST["codCompara"] == $_POST["codigo"]){
				$login = $_POST['login'];
				$senha = $_POST['password'];
				//$codigo = $_POST['codigo'];
				$sessao = array(
					'usuario_id'		=> 0,
					'perfilusuario_id' 	=> '',
					'username'  => '',
					'usuario_login' 	=> '',
					'usuario_senha' 	=> '',
					'nome' 		=> ''
			    );
				$this->session->set_userdata($sessao);
        		$ret = $this->M_usuarios->logar($login, $senha);
	        		foreach($ret->result() as $linha) {

						$sessao = array(
							'usuario_id'		=> $linha->usuario_id,
						    'username'	=> $linha->username,
						    'perfilusuario_id'	=> $linha->perfilusuario_id,
						    'usuario_login' 	=> $login,
						    'usuario_senha' 	=> $senha,
						    'nome' 	=> $linha->nome
						);

						$this->session->set_userdata($sessao);
	        			break;
	        		}

	        		$usuario_id = $this->session->userdata('usuario_id');

	        		if($usuario_id != 0) {
	        			$this->dados["msg"] = "Logado.";
	        			$countMenu = $this->M_usuarios->countUsuarioMenu($usuario_id);
	        			if ($countMenu > 0) {
							header("location:".base_url()."CI_inicio");
	        			}else{
							header("location:".base_url()."CI_visualizacao");
	        			}
	        		} else {
	        			$this->dados["msg"] = '<span class="camposObrigatorios ">Usuário ou senha inválida.</span>';
	        			$this->index();
	        		}

			// }else{
			// 	$this->dados['msg'] = '<span class="camposObrigatorios ">Código inválido.</span>';
			// 	$this->index();
			// } 
		}else {
				$this->dados['msg'] = '<span class="camposObrigatorios ">Login, senha ou código inválido.</span>';
        		$this->index();
       	}
	}

	function recuperar(){
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'mmadrugadeazevedo',
		    'smtp_pass' => 'hacker22',
		    'mailtype'  => 'html', 
		    'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$list = array('mmadrugadeazevedo@gmail.com');
		
		// Set to, from, message, etc.
		$this->email->from('mmadrugadeazevedo@gmail.com', 'Me');
        $this->email->reply_to('mmadrugadeazevedo@gmail.com', 'Me');
        $this->email->to($_POST['email']);
        $this->email->subject('Recuperação de Senha');
        $this->email->message('<html><body>Este é o e-mail que será enviado para recuperar sua senha.</body></html>');
		
		$result = $this->email->send();
		if ($result){
			$this->dados['msg'] = '<span class="camposObrigatorios ">Verifique sua senha em seu e-mail.</span>';
			$this->index();
		}	
	}

	function validarEmail(){
		$this->db->select('*');
		$this->db->from(' usuario');
		$this->db->where('email',$_POST['email']);
		$return = $this->db->count_all_results();
		if ($return > 0){
			return $this->db->get();
		} else {
			return false;
		}	
	}
	
	function deslogar() {
       	$this->session->sess_destroy();
		header('Location:'.base_url().'CI_login');
	}
	
	function recoverPassword(){
		if (isset($this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"])){
				$this->dados['title'] = $this->M_usuarios->selecionar($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];				
			}else{
				$this->dados['title'] = $this->M_configuracoes->selecionar('titulo')->result_array()[0]["value"];
			}
		$this->load->view('inc/topo',$this->dados);
		$this->load->view('senha');
		$this->load->view('inc/rodape');
	}
	
}
?>
