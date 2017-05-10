<?php
class CI_install extends CI_Controller {
	
		public function __construct()
       {
            parent::__construct();
            $this->load->helper('url');
			/*if ($this->config->item('installed') == true){
			    redirect('CI_login', 'refresh');
			}*/
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
			$pre_error .= 'application/config/config.php precisa ter permissão de escrita 777!';
		}
		if (!is_writable('uploads')) {
			$pre_error .= 'application/config/config.php precisa ter permissão de escrita 777!';
		}
		if (!in_array('mod_rewrite', apache_get_modules())){
			$pre_error .= 'O mod_rewrite necessita estar habilitado!';
		}
		$this->dados['pre_error'] = $pre_error;

		$this->dados['title'] = "Instalação do Servidor de Contexto";
		$this->load->view('installation/topo',$this->dados);
		$this->load->view('installation/step1');
		$this->load->view('inc/rodape');
	}

	function step2(){
		$this->dados['title'] = "Instalação do Servidor de Contexto";
		$this->dados['baseurl'] = $this->full_url($_SERVER);
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
		$this->form_validation->set_rules('admin_username', 'Admin Username', 'required');
		$this->form_validation->set_rules('admin_password', 'Admin Password', 'required');
		$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
		$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
		if ($this->form_validation->run() == FALSE) {
			$this->step2();
			
		} else {
			$this->dados['title'] = "Instalação do Servidor de Contexto";
			$this->load->view('installation/topo',$this->dados);
			if (write_database() == true && write_config() == true)
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
	    $uri = str_replace("CI_install/step1","",$s['REQUEST_URI']);
	    $uri = str_replace("CI_install/step2","",$uri);
	    $uri = str_replace("CI_install/step3","",$uri);
	    return $protocol . '://' . $host . $port . $uri;
	}

	function write_database() {
		// Config path
		$template_path 	= '../application/defaults/database.php';
		$output_path 	= '../application/config/database.php';
		// Open the file
		$database_file = file_get_contents($template_path);
		$new  = str_replace("%HOSTNAME%",$_POST['database_host'],$database_file);
		$new  = str_replace("%USERNAME%",$_POST['database_username'],$new);
		$new  = str_replace("%PASSWORD%",$_POST['database_password'],$new);
		$new  = str_replace("%DATABASE%",$_POST['database_name'],$new);
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

	function write_config() {
		// Config path
		$template_path 	= '../application/defaults/config.php';
		$output_path 	= '../application/config/config.php';
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
		$sql = "CREATE DATABASE IF NOT EXISTS ".$_POST['database_name'];
		$this->db->query($sql);
		
		require __DIR__ . '/vendor/autoload.php';

		$phinxApp = new \Phinx\Console\PhinxApplication();
		$phinxTextWrapper = new \Phinx\Wrapper\TextWrapper($phinxApp);

		$phinxTextWrapper->setOption('configuration', '/path/to/phinx.yml');
		$phinxTextWrapper->setOption('parser', 'YAML');
		$phinxTextWrapper->setOption('environment', 'development');

		$log = $phinxTextWrapper->getMigrate();

		/*$sql = "CREATE DATABASE IF NOT EXISTS ".$_POST['database_name'];
		$this->db->query($sql);



		$query = file_get_contents('../../application/installDB.sql');

		$sqls = explode(';', $query);
		array_pop($sqls);

		foreach($sqls as $statement){
			$statment = $statement . ";";
			$this->db->query($statement);	
		}*/
	}
}
?>