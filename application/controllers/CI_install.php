<?php
class CI_install extends CI_Controller {
	
		public function __construct()
       {
            parent::__construct();
            $this->load->helper('url');
			if ($this->config->item('installed') == true){
			    redirect('CI_login', 'refresh');
			}
       }
 
	function index(){	
		$this->dados['title'] = "Instalação do Servidor de Contexto";
		$this->load->view('installation/topo',$this->dados);
		$this->load->view('installation/inicio');
		$this->load->view('inc/rodape');
	}

	function step1(){
		if(isset($_POST['pre_error'])){
			$this->dados['pre_error'] = $_POST['pre_error'];
			if($_POST['pre_error'] ==''){
			   redirect('CI_install/step2', 'refresh');
		  	}
		}
		$pre_error = "";
	      
		if (phpversion() < '5.0') {
			$pre_error = 'Seu servidor precisa possuir PHP5 ou mais recente para que esta aplicação funcione!<br />';
		}
		if (!extension_loaded('pgsql')) {
			$pre_error .= 'A estenção PostgreSQL precisa estar carregada para que essa aplicação funcione!<br />';
		}
		if (!is_writable('application/config/database.php')) {
			$pre_error .= 'application/config/database.php precisa ter permissão de escrita 777!<br />';
		}
		if (!is_writable('application/config/config.php')) {
			$pre_error .= 'application/config/config.php precisa ter permissão de escrita 777!<br />';
		}
		if (!in_array('mod_rewrite', apache_get_modules())) {
			$pre_error .= 'O modulo "mod_rewrite" do apache precisa estar ativado!<br />';
		}
		$this->dados['pre_error'] = $pre_error;

		$this->dados['title'] = "Instalação do Servidor de Contexto";
		$this->load->view('installation/topo',$this->dados);
		$this->load->view('installation/step1');
		$this->load->view('inc/rodape');
	}

	function step2(){
		$this->dados['title'] = "Instalação do Servidor de Contexto";
		$full_url = $this->full_url($_SERVER);
		$url = strpos($full_url, "CI_install");
		$base_url = str_split($full_url, $url)[0];
		$this->dados['baseurl'] = $base_url;
		$this->load->view('installation/topo',$this->dados);
		$this->load->view('installation/step2');
		$this->load->view('inc/rodape');
	}

	function step3(){
		$this->form_validation->set_rules('database_host', 'Database Host', 'required');
		$this->form_validation->set_rules('database_name', 'Database Name', 'required');
		$this->form_validation->set_rules('database_username', 'Database Username', 'required');
		$this->form_validation->set_rules('database_password', 'Database Password', 'required');
		$this->form_validation->set_rules('application_baseurl', 'Base URL', 'required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			$this->step2();
			
		} else {
			$this->dados['title'] = "Instalação do Servidor de Contexto";
			$this->load->view('installation/topo',$this->dados);
			if ($this->write_database() == true && $this->write_config() == true){
				$this->create_database();
				$this->load->view('installation/step3');
			}else
				$this->load->view('installation/step2');
			$this->load->view('inc/rodape');
		}
	}

	function step4(){
		$this->form_validation->set_rules('admin_username', 'Admin Username', 'required');
		$this->form_validation->set_rules('admin_password', 'Admin Password', 'required');
		$this->form_validation->set_rules('admin_email', 'Admin Email', 'required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			$this->step3();
			
		} else {
			$this->dados['title'] = "Instalação do Servidor de Contexto";
			$this->load->view('installation/topo',$this->dados);
			if ($this->create_admin() == true)
				$this->load->view('installation/installSucess');
			else
				$this->load->view('installation/installFail');
			$this->load->view('inc/rodape');
		}
	}

	function full_url($s){
	    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
	    $sp = strtolower($s['SERVER_PROTOCOL']);
	    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
	    $port = $s['SERVER_PORT'];
	    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
	    $host = isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME'];
	    $uri = str_replace("CI_install/step2", "", $s['REQUEST_URI']);
	    $uri = str_replace("CI_install/step3", "", $s['REQUEST_URI']);
	    return $protocol . '://' . $host . $port . $uri;
	}

	function write_database() {
		// Config path
		$template_path 	= 'application/defaults/database.php';
		$output_path 	= 'application/config/database.php';
		$phinx_template_path 	= 'application/defaults/phinx.yml';
		$phinx_output_path 	= 'phinx.yml';
		// Open the file
		$database_file = file_get_contents($template_path);
		$new  = str_replace("%HOSTNAME%",$_POST['database_host'],$database_file);
		$new  = str_replace("%USERNAME%",$_POST['database_username'],$new);
		$new  = str_replace("%PASSWORD%",$_POST['database_password'],$new);
		$new  = str_replace("%DATABASE%",$_POST['database_name'],$new);

		$phinx_database_file = file_get_contents($phinx_template_path);
		$new_phinx  = str_replace("%HOSTNAME%",$_POST['database_host'],$phinx_database_file);
		$new_phinx  = str_replace("%USERNAME%",$_POST['database_username'],$new_phinx);
		$new_phinx  = str_replace("%PASSWORD%",$_POST['database_password'],$new_phinx);
		$new_phinx  = str_replace("%DATABASE%",$_POST['database_name'],$new_phinx);
		// Write the new database.php file
		$handle = fopen($output_path,'w+');
		$handle_phinx = fopen($phinx_output_path,'w+');
		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);
		@chmod($phinx_output_path,0777);
		// Verify file permissions
		if(is_writable($output_path) && is_writable($phinx_output_path) ) {
			// Write the file
			if(fwrite($handle,$new) && fwrite($handle_phinx,$new_phinx)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function write_config() {
		// Config path
		$template_path 	= 'application/defaults/config.php';
		$output_path 	= 'application/config/config.php';
		// Open the file
		$config_file = file_get_contents($template_path);
		$new  = str_replace("%INSTALLED%","TRUE",$config_file);
		$new  = str_replace("%BASEURL%",$_POST['application_baseurl'],$new);
		// Write the new database.php file
		$handle = fopen($output_path,'w+');
		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);
		// Verify file permissions
		if(is_writable($output_path)) {
			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function create_database(){
		$outputMigration = `php vendor/bin/phinx migrate -e development`;
		$outputSeed = `php vendor/bin/phinx seed:run -e development`;
	}

	function create_admin(){
		$this->M_usuarios->setUsuarioPerfil(1);
		$this->M_usuarios->setUsuarioNome('Administrador');
		$this->M_usuarios->setUsuarioUsername($_POST["admin_username"]);
		$passwordHash = password_hash($_POST["admin_password"], PASSWORD_DEFAULT);
		$this->M_usuarios->setUsuarioPassword($passwordHash);
		$this->M_usuarios->setUsuarioEmail($_POST["admin_email"]);
		$token = json_decode($this->M_keys->insert_key(10))->key;
		$this->M_usuarios->setUsuarioToken($token);

		if ($this->M_usuarios->salvar() == "inc"){
			return true;
		}
	}
}
?>