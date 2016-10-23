<?php
	class M_Geral extends CI_Model{
		function __construct()
		{
			parent::__construct();
		}
		function verificaSessao(){ 
			if($this->session->userdata('usuario_id') == '' or $this->session->userdata('usuario_id') == null or $this->session->userdata('usuario_id') == 0){
				$this->session->sess_destroy();
        		header('Location: '.base_url().'CI_login');
			}
    	}

    	function loadTitle($id=""){
			$this->load->model('M_configuracoes');
			if ($id=="")
    			$title = $this->M_configuracoes->selecionar(1)->result_array()[0]["title"];
    		else
    			$title = $this->M_configuracoes->selByUser($id)->result_array()[0]["title"];
    		return $title;
    	}

    	function uploadFile($name,$samefilename){
    		$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'gif|jpg|png';
			//$config['max_size']	= '100';
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
			if($samefilename)
				$config['file_name']=$name;          
        	$config['overwrite'] = true;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload($name))
			{
				$error = array('error' => $this->upload->display_errors());

				return $error;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				return $data;
			}
    	}
		
		function buscarImagem($campo,$tabela,$codigo){
			$codigo     = $this->db->query("SELECT $campo from $tabela where id=$codigo");
			$resultado  = $codigo->result();
			return $resultado[0]->$campo;
		}

		function sendEmail($dest,$message,$subject){
			$config = Array(
                'protocol' => 'smtp',
                'smtp_host' => $this->M_configuracoes->selecionar('email_host')->result_array()[0]['value'],
                'smtp_port' => $this->M_configuracoes->selecionar('email_port')->result_array()[0]['value'],
                'smtp_user' => $this->M_configuracoes->selecionar('email_user')->result_array()[0]['value'],
                'smtp_pass' => $this->M_configuracoes->selecionar('email_pass')->result_array()[0]['value'],
                'mailtype'  => 'html', 
                'charset'   => 'utf-8'
            );
			$this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($this->M_configuracoes->selecionar('email_from')->result_array()[0]['value'], 'Me');
            $this->email->reply_to($this->M_configuracoes->selecionar('email_from')->result_array()[0]['value'], 'Me');
       		$this->email->to($dest);
            $this->email->subject($subject);
            $this->email->message($message);
			$result = $this->email->send();
			
			return $result;
		}

		function generatePassword($length = 8) {
		    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		    $count = mb_strlen($chars);

		    for ($i = 0, $result = ''; $i < $length; $i++) {
		        $index = rand(0, $count - 1);
		        $result .= mb_substr($chars, $index, 1);
		    }

		    return $result;
		}
		
		function build_menu()
	    {
			$perfilusuario_id = $this->session->userdata('perfilusuario_id');

			$this->db->select('superAdm');
            $this->db->from('perfisusuarios');
            $this->db->where('perfilusuario_id',$perfilusuario_id);
            
            $isAdm = $this->db->get()->row()->superAdm;

	    	$this->db->select('menus.*');
			$this->db->from('menus');
			$this->db->join('relmenuperfil','menus.menu_id = relmenuperfil.menu_id', 'left');
			if ($isAdm == 'f'){
				$this->db->where('relmenuperfil.perfilusuario_id',$perfilusuario_id);
			}
	    	$this->db->order_by('ordem','asc');    
	        $query = $this->db->get();

			$menu = false;
	        foreach ($query->result() as $row)
	        {
	            $menu_array[$row->menu_id] = array('name' => $row->nome,'parent' => $row->parente,'caminho' => $row->caminho);
				$menu = true;
	        }
	
			if ($menu == true){
		        $this->_generate_menu($menu_array, 0);
			}	
	    }
	
	    function _generate_menu($arr, $parent)
	    {    
	        $has_childs = false;
	
	        foreach($arr as $key => $value)
	        {
	            if ($value['parent'] == $parent) 
	            {       
	                if ($has_childs === false)
	                {
	                    $has_childs = true;
	                    echo '<ul>';
	                }
					
					if ($value['caminho'] == NULL || $value['caminho'] == "") {
		                echo '<li><a href="javascript:;"  title="">' .$value['name'] . '</a>';
					} else {
		                echo '<li><a href="'.base_url().$value['caminho'].'"  title="">' . $value['name'] . '</a>';						
					}
	
	                $this->_generate_menu($arr, $key);
	
	                echo '</li>';
	            }
	
	        }
	
	        if ($has_childs === true) echo '</ul>';
	    } 
	    
		function buscarNomeMenu($idMenu) {
			$this->db->select('nome');
			$this->db->from('menus');
			$this->db->where('menu_id', $idMenu);	
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$menuNome = $row->nome;
			}
			return $menuNome;
		}
	}
?>