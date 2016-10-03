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

    	function checkServerStatus(){
    		echo "Oi";
    		$url = $this->input->get('addr');
			$curl  = curl_init($url);

			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($curl);
			$info = curl_getinfo($curl);

			curl_close($curl);

			if ($info['http_code'] == 200)
				return TRUE;
			else
				return FALSE;
    	}

    	function loadTitle($id=""){
			$this->load->model('M_configuracoes');
			if ($id=="")
    			$title = $this->M_configuracoes->selecionar(1)->result_array()[0]["title"];
    		else
    			$title = $this->M_configuracoes->selByUser($id)->result_array()[0]["title"];
    		return $title;
    	}

    	function uploadFile($name){
    		$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'gif|jpg|png';
			//$config['max_size']	= '100';
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
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
		
		function build_menu()
	    {
	    	$this->db->select('menus.*');
			$this->db->from('menus');
			$this->db->join('relmenuperfil','menus.menu_id = relmenuperfil.menu_id');
			$this->db->where('relmenuperfil.perfilusuario_id',$this->session->userdata('perfilusuario_id'));
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