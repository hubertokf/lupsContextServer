<?php 

class CI_login extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
            $this->load->model('M_geral');
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
		if(!empty($_POST["login"]) && !empty($_POST["password"])) {
			$login = $_POST['login'];
			$senha = $_POST['password'];
			$sessao = array(
				'usuario_id'		=> 0,
				'perfilusuario_id' 	=> '',
				'username'  => '',
				'usuario_login' 	=> '',
				'usuario_senha' 	=> '',
				'nome' 		=> ''
		    );
			$this->session->set_userdata($sessao);
    		$user = $this->M_usuarios->logar($login)->row();
    		if (password_verify($senha, $user->password)) {
				$sessao = array(
					'usuario_id'		=> $user->usuario_id,
				    'username'			=> $user->username,
				    'perfilusuario_id'	=> $user->perfilusuario_id,
				    'usuario_login' 	=> $user->username,
				    'nome' 				=> $user->nome
				);

				$this->session->set_userdata($sessao);

    			$this->dados["msg"] = "Logado.";
    			$countMenu = $this->M_usuarios->countUsuarioMenu($user->usuario_id);
    			if ($countMenu > 0) {
					header("location:".base_url()."CI_inicio");
    			}else{
					header("location:".base_url()."CI_visualizacao");
    			}
			}
			else {
			    $this->dados["msg"] = '<span class="camposObrigatorios ">Usuário ou senha inválida.</span>';
    			$this->index();
			}

		}else {
			$this->dados['msg'] = '<span class="camposObrigatorios ">Login, senha ou código inválido.</span>';
    		$this->index();
       	}
	}

	function recuperar(){
		$newPass = $this->M_geral->generatePassword();
		$email = $_POST['email'];
        $usuarios = $this->M_usuarios->pesquisar('', array('email'=>$email))->row();
		$passwordHash = password_hash($newPass, PASSWORD_DEFAULT);

        if ($usuarios->email == $_POST['email']){
	        $this->M_usuarios->setUsuarioId($usuarios->usuario_id);
			$this->M_usuarios->setUsuarioPerfil($usuarios->perfilusuario_id);
			$this->M_usuarios->setUsuarioNome($usuarios->nome);
			$this->M_usuarios->setUsuarioUsername($usuarios->username);
			$this->M_usuarios->setUsuarioPassword($passwordHash);
			$this->M_usuarios->setUsuarioEmail($usuarios->email);
			$this->M_usuarios->setUsuarioTelefone($usuarios->telefone);
			$this->M_usuarios->setUsuarioCelular($usuarios->celular);
			$this->M_usuarios->setUsuarioWebsiteTitulo($usuarios->website_titulo);
			$this->M_usuarios->setUsuarioImgCabecalho($usuarios->img_cabecalho);
			$this->M_usuarios->setUsuarioImgProjeto($usuarios->img_projeto);
			$this->M_usuarios->setUsuarioCorPredominante($usuarios->cor_predominante);
			$this->M_usuarios->setUsuarioToken($usuarios->token);

			$subject = 'Recuperação de Senha';
	        $message = 'Sua nova senha é: '.$newPass;

	        $result = $this->M_geral->sendEmail($usuarios->email,$message,$subject);

			if ($result){

				if ($this->M_usuarios->salvar() == "alt"){
					$this->dados['msg'] = '<span class="camposObrigatorios ">Verifique sua senha em seu e-mail.</span>';
					$this->index();
				}else{
					$this->dados['msg'] = '<span class="camposObrigatorios ">Não foi possível atualizar sua senha.</span>';
					$this->index();
				}
			}else{
				$this->dados['msg'] = '<span class="camposObrigatorios ">Não foi possível enviar o e-mail.</span>';
				$this->index();
			}
		}else{
			$this->dados['msg'] = '<span class="camposObrigatorios ">E-mail não cadastrado.</span>';
			$this->recoverPassword();
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
