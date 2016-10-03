<?php
	class CI_agenda extends CI_controller {
	
		public function __construct()
		{	
			header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
			if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
			    die();
			}
			parent::__construct();
			
		$this->load->model('M_geral');
		$this->load->model('M_configuracoes');
			$this->load->model('M_agendamentos');
			$this->load->model('M_ambientes');
			$this->load->model('M_usuarios');
			$this->load->model('M_sensores');
			$this->M_geral->verificaSessao();
			if ($this->session->userdata('usuario_id') != 0 && $this->session->userdata('usuario_id') != ""){
				$this->dados['isLoged'] = true;
				$this->dados['usuario_logado'] = $this->session->userdata('nome');
			}else
				$this->dados['isLoged'] = false;
			if (isset($this->M_configuracoes->selByUser($this->session->userdata('usuario_id'))->result_array()[0]["titulo"]))
			$this->dados['title'] = $this->M_configuracoes->selByUser($this->session->userdata('usuario_id'))->result_array()[0]["titulo"];
		else
			$this->dados['title'] = $title = $this->M_configuracoes->selecionar(1)->result_array()[0]["titulo"];
			$this->dados["caminho"] = $this->uri->segment(1)."/".$this->uri->segment(2);
		}
	
		function index()
		{	
			$this->pesquisa();
		}
		
		function pesquisa($nr_pagina=20 ){
			$usuarioId = $this->session->userdata('usuario_id');
			$usuarioPerfil = $this->session->userdata('perfilusuario_id');
			$this->dados["metodo"] = "pesquisa";
			if ((int)$usuarioPerfil <= 2) {	
				$this->dados["linhas"] = $this->M_agendamentos->pesquisar('', array(), $nr_pagina, $this->uri->segment(5));
			} else {
				$this->dados["linhas"] = $this->M_agendamentos->pesquisar('', array('agendamento.usuario_id' => $this->session->userdata('usuario_id')), $nr_pagina, $this->uri->segment(5));				
			}
                        
                        //foreach ($this->dados["linhas"] as $linha){
                        
			$this->dados["nr_pagina"] = $nr_pagina;
			$this->dados["total"] = $this->M_agendamentos->numeroLinhasTotais();
			$this->dados["tituloPesquisa"] = "Registro de Agendamentos";

			//$this->dados["sensores"] = $this->M_agendamentos->getSensorList();		
			
			$pag['base_url'] = base_url.$this->dados["caminho"]."/".$this->dados["metodo"]."/".$nr_pagina."/";
			$pag['total_rows'] = $this->dados["total"];
			$pag['uri_segment']	= 5;
			$pag['per_page'] = $this->dados["nr_pagina"];
			$this->pagination->initialize($pag); 
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('inc/topoPesquisa');
			$this->load->view('agenda/agendamentos/pesquisa');
			$this->load->view('inc/rodape');
		}
	
		function cadastro(){
			$this->dados["usuario"] = $this->M_usuarios->pesquisar(); 
			$this->dados["ambiente"] = $this->M_ambientes->pesquisar();
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('agenda/agendamentos/cadastro');
			$this->load->view('inc/rodape');
		}
		
		function gravar() {
			$this->form_validation->set_rules('agendamento_ambiente', 'ambiente', 'trim|required');
			$this->form_validation->set_rules('agendamento_usuario', 'Usuário', 'trim|required');
			$this->form_validation->set_rules('agendamento_datetimeinicial', 'Período Inicial', 'trim|required');
			$this->form_validation->set_rules('agendamento_datetimefinal', 'Período Final', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="field-errors">', '</div>');
			$this->form_validation->set_message('required', 'Você deve preencher o campo "%s".');
			if ($this->form_validation->run() == FALSE) {
				if ($_POST['agendamento_id'] != "") {
					$this->editar($_POST['agendamento_id']);
				} else {
					$this->cadastro();
				}
				
			} else {
				$this->M_agendamentos->setAgendamentoId($_POST["agendamento_id"]);
				$this->M_agendamentos->setAgendamentoAmbiente($_POST["agendamento_ambiente"]);
				$this->M_agendamentos->setAgendamentoUsuario($_POST["agendamento_usuario"]);
				$this->M_agendamentos->setAgendamentoDesc($_POST["agendamento_desc"]);
				$this->M_agendamentos->setAgendamentoDateTimeInicial($_POST["agendamento_datetimeinicial"]);
				$this->M_agendamentos->setAgendamentoDateTimeFinal($_POST["agendamento_datetimefinal"]);
				if ($this->M_agendamentos->salvar() == "inc"){
					$this->dados["msg"] = "Dados registrados com sucesso!";
					$this->pesquisa();	
				}
				else {
					$this->dados["msg"] = "Dados alterados com sucesso!";
					$this->pesquisa();	
				}
			}			
		}
		
		function excluir($id=""){
			if ($id==""){	
				if(isset($_POST["item"])) {
					$this->M_agendamentos->setAgendamentoId($_POST["item"]);	
					$this->M_agendamentos->excluir();
				}
			}
			else{
				$this->M_agendamentos->setAgendamentoId($id);	
				$this->M_agendamentos->excluir();
			}
			$this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
			$this->pesquisa();
		}
	
	   function editar() {
			
			if(isset($_POST["item"])) {
				$this->dados["registro"] = $this->M_agendamentos->selecionar($_POST["item"]);
			}
			$this->cadastro();
		}
		
		function selecionar() {
			$this->dados["ambiente"] = $this->M_ambientes->pesquisar();
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('agenda/agendamentos/selecao');
			$this->load->view('inc/rodape');
		}

		function buscar() {
			$this->dados["registro"] = $this->M_agendamentos->buscaEventos($_POST['item']);
			$this->load->view('inc/agenda',$this->dados);
		}

		function visualizar() {
			$prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => ''.base_url().'agenda/CI_agenda/visualizar',
               'template' =>  '
				   {table_open}<table class="events-calendar" border="0" cellpadding="3" cellspacing="0">{/table_open}

				   {heading_row_start}<tr class="top-calendar">{/heading_row_start}

				   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
				   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
				   {heading_next_cell}<th class="next-month"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

				   {heading_row_end}</tr>{/heading_row_end}

				   {week_row_start}<tr class="week-calendar">{/week_row_start}
				   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
				   {week_row_end}</tr>{/week_row_end}

				   {cal_row_start}<tr class="days-calendar">{/cal_row_start}
				   {cal_cell_start}<td>{/cal_cell_start}

				   {cal_cell_content}<a href="javascript:;" rel="{content}"><span>{day}</span></a>{/cal_cell_content}
				   {cal_cell_content_today}<div class="highlight"><a href="javascript:;" rel="{content}"><span>{day}</span></a></div>{/cal_cell_content_today}

				   {cal_cell_no_content}<span>{day}<span>{/cal_cell_no_content}
				   {cal_cell_no_content_today}<div class="highlight"><span>{day}</span></div>{/cal_cell_no_content_today}

				   {cal_cell_blank}&nbsp;{/cal_cell_blank}

				   {cal_cell_end}</td>{/cal_cell_end}
				   {cal_row_end}</tr>{/cal_row_end}

				   {table_close}</table>{/table_close}
				'
             );
	
			$this->load->library('Calendar',$prefs);

			$dados = $this->M_agendamentos->pesquisar();
			
			function howDays($from, $to) {
			    $first_date = strtotime($from);
			    $second_date = strtotime($to);
			    $offset = $second_date-$first_date; 
			    return floor($offset/60/60/24);
			}

 		    $data = array();
 		    if (isset($_POST['agendamento_ambiente'])){
 		    	$this->session->set_userdata('ambiente_id', $_POST['agendamento_ambiente']);
 		    }
 		    $idambiente = $this->session->userdata('ambiente_id');
 		    $dadosAgendamento = $this->M_agendamentos->pesquisar($select='', $where='agendamento.ambiente_id = '.$idambiente.'', $limit=9999, $offset=0, $ordem='asc');	

 		    foreach ($dadosAgendamento as $linha){	
 		    	$totalDays = howDays($linha['datetimeinicial'],$linha['datetimefinal']); 
 		    	for ($i = 0; $i <= $totalDays; $i ++){
		    		$newdate = strtotime ( '+'.$i.' day' , strtotime($linha['datetimeinicial']));
					$valorAnoData = mdate('%Y', $newdate);
	 		    	$valorMesData = mdate('%m', $newdate);
	 		    	$valorDiaData = (int)mdate('%d', $newdate);
					if (isset($data[$valorAnoData][$valorMesData][$valorDiaData])){
						$data[$valorAnoData][$valorMesData][$valorDiaData] .= "||".$linha['agendamento_id'];
					} else {
						$data[$valorAnoData][$valorMesData][$valorDiaData] = $linha['agendamento_id'];
					}
				}	
		    }

   			$this->dados["calendario"] = $this->calendar->generate($this->uri->segment(4), $this->uri->segment(5), $data);

			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('agenda/agendamentos/visualizar');
			$this->load->view('inc/rodape');			
		}
	
		function verificarData() {
			
			$this->dados['totalRegistros'] = $this->M_agendamentos->pesquisarIntervalosDentro($select='',$_POST['idAg'], $_POST['DateTimeInicial'], $_POST['DateTimeFinal'], $_POST['agendamentoambiente']);					

			if ($this->dados['totalRegistros'] == 0) {
				$this->dados['totalRegistros'] = $this->M_agendamentos->pesquisarIntervalosFora($select='',$_POST['idAg'], $_POST['DateTimeInicial'], $_POST['DateTimeFinal'], $_POST['agendamentoambiente']);
			}
			if ($this->dados['totalRegistros'] == 0) {
				$this->dados['totalRegistros'] = $this->M_agendamentos->pesquisarIntervalosservidorbordaEsquerda($select='',$_POST['idAg'], $_POST['DateTimeInicial'], $_POST['agendamentoambiente']);	
			}
			if ($this->dados['totalRegistros'] == 0) {
				$this->dados['totalRegistros'] = $this->M_agendamentos->pesquisarIntervalosservidorbordaDireita($select='',$_POST['idAg'], $_POST['DateTimeFinal'], $_POST['agendamentoambiente']);	
			}
			
			$this->load->view('inc/totalAgendamentos',$this->dados);
			
		}

		function relatorio() {
			$this->dados["usuario"] = $this->M_usuarios->pesquisar(); 
			$this->dados["ambiente"] = $this->M_ambientes->pesquisar();
			$this->load->view('inc/topo',$this->dados);
			$this->load->view('inc/menu');
			$this->load->view('agenda/agendamentos/relatorio');
			$this->load->view('inc/rodape');			
		}

		function gerarRelatorio() {
			header('Pragma: public');             // required
			header('Expires: 0');                       // to prevent caching
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: private',false);
			header('Content-Type: application/force-download');
			header('Content-Transfer-Encoding: binary');
			header('Connection: close');
			$this->load->library('cezpdf');
			$this->load->helper('pdf');
			
			prep_pdf(); // creates the footer for the document we are creating.
	
			$dadosBusca = array();
			
			if (isset($_POST['usuario_id']) and $_POST['usuario_id'] != "") {
				$dadosBusca['usuario_id'] = $_POST['usuario_id'];
			}

			if (isset($_POST['ambiente_id']) and $_POST['ambiente_id'] != "") {
				$dadosBusca['ambiente_id'] = $_POST['ambiente_id'];
			}

			$dadosRelatorio = $this->M_agendamentos->pesquisar($select='', $where = $dadosBusca, $limit='', $offset=0, $ordem='desc', $orderBy="datetimeinicial");

			foreach ($dadosRelatorio as $linha){
				$db_data[] = array(
					'agendamento' 		=> utf8_decode($linha['agendamento_id']),
					'usuario' 			=> utf8_decode($linha['nome_usuario']),
					'ambiente' 			=> utf8_decode($linha['nome_ambiente']),
					'descricao' 		=> utf8_decode($linha['descricao']),
					'datetimeinicial' 	=> utf8_decode($linha['datetimeinicial']),
					'datetimefinal' 	=> utf8_decode($linha['datetimefinal'])
				);
			}

			$col_names = array(
				'agendamento' 		=> utf8_decode('Agendamento'),
				'usuario'			=> utf8_decode('Usuario'),
				'ambiente'			=> utf8_decode('Ambiente'),
				'datetimeinicial' 	=> utf8_decode('Período Inicial'),
				'datetimefinal' 	=> utf8_decode('Período Final'),
				'descricao'			=> utf8_decode('Observações')
			);
			
			$this->cezpdf->ezTable($db_data, $col_names, 'Lista de Agendamentos', array('width'=>550));
			$this->cezpdf->ezStream();			
		}
		
	}
?>