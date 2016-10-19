<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Publicacoes extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['index_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['index_delete']['limit'] = 50; // 50 requests per hour per user/key

        //Load Models
        $this->load->model('M_sensores');
        $this->load->model('M_publicacoes');
        $this->load->model('M_usuarios');
        $this->load->model('M_relcontextointeresse');
    }
    // Requisições GET enviadas para o index.
    public function index_get(){
        // Requisições sem ID - lista todos os elementos
        $id = $this->get('id');
        if ($id === NULL){
            // Pega publicações do banco através do model publicacao
            $publicacoes = $this->M_publicacoes->pesquisar('', array(), '', 0, 'publicacao_id', 'asc', FALSE, array())->result_array();

            if ($publicacoes){
                // Converte os dados adquiridos do banco (array) para Json
                $publicacoes_json = json_encode($publicacoes, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($publicacoes_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No publications were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
        // Requisições com ID - lista informações do elemento
            $publicacao = $this->M_publicacoes->selecionar($id)->result_array();
            if ($publicacao){
                // Converte os dados adquiridos do banco (array) para Json
                $publicacao_json = json_encode($publicacao, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($publicacao_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No publication was found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post(){
        $content = $this->post('content');
        $local = FCPATH."regras/";
        $localMotor = FCPATH."motorRegras/";

        //verifica se o content da requisição veio
        if ($content === NULL || empty($content)){
            //se não veio, retorna erro 204 (no content)
            $message = ['status' => FALSE,
                        'message' => 'No content was found'];
            $this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
        }else{
            //se veio, o framework já transforma o json para array associativo com os dados

            //salva no objeto do model
            //verifica se a publicação veio com id incremental ou com uuid
            if (isset($content['sensor_uuid'])) {
                $sensor = $this->M_sensores->getByUuid($content['sensor_uuid'])->row();
                $this->M_publicacoes->setPublicacaoSensor($sensor->sensor_id);
            } else {                
                $this->M_publicacoes->setPublicacaoSensor($content['sensor_id']);
            }
            $this->M_publicacoes->setPublicacaoDataColeta($content['datacoleta']);
            $this->M_publicacoes->setPublicacaoDataPublicacao($content['datapublicacao']);
            $this->M_publicacoes->setPublicacaoValorColetado($content['valorcoletado']);

            //pega do BANCO o ambiente_id o qual aquele sensor estah instalado, valormax e min do sensor, e status do ambiente
            $sensor = $this->M_sensores->selecionar($content['sensor_id'])->result_array();

            //Se o sensor estiver desativado ou estiver num ambiente desativado, nao sera feita a publicacao na base de dados
            if($sensor[0]["ambiente_status"]=='t'){
                if($sensor[0]["status"]=='t'){
                    //verifica se valor coletado é um codigo de erro
                    if($content['valorcoletado'] < 990){
                        //salva o model no banco
                        if ($this->M_publicacoes->salvar() == "inc"){
                            //se retornou inc, está salvo no banco
                            $message = ['status' => TRUE,
                            'message' => 'Dados registrados com sucesso!'];

                            $regras = $this->M_relcontextointeresse->getBySensor($content['sensor_id'])->result_array();

                            if($content['dispararegra'] == true){
                                foreach ($regras as $regra) {
                                    if ($regra['ativaregra'] == 't'){
                                        if($regra['regra_id']!=null && $regra['regra_tipo']==1 && $regra['regra_status']=='t' && $regra['regra_arquivo']!=null){
                                            // EXECUTA REGRA PYTHON
                                            $cmd = $local ."".$regra['regra_arquivo']." ".$regra['contextointeresse_id']." ".$regra['sensor_id'];
                                            $command = escapeshellcmd($cmd);
                                            $regraOutput = shell_exec($command);

                                        }elseif($regra['regra_id']!=null && $regra['regra_tipo']==3 && $regra['regra_status']=='t' && $regra['regra_arquivo']!=null) {
                                            
                                            $cmd = $localMotor ."main.py ".$regra['regra_arquivo'];
                                            $command = escapeshellcmd($cmd);
                                            $regraOutput = shell_exec($command);
                                        }
                                    }
                                }
                            }

                            // retorna 201 (criado)
                            $this->set_response($message, REST_Controller::HTTP_CREATED);
                        }else{
                            //se não retornou inc
                            $message = ['status' => FALSE,
                            'message' => 'Dados não registrados com sucesso!'];
                            // retorna 409 (conflito)
                            $this->set_response($message, REST_Controller::HTTP_CONFLICT);
                        }
                    }else{
                        // ENVIA EMAIL DE VALOR DE ERRO

                        $usuarios = $this->M_usuarios->selByPerfilUsuario(2)->result_array();

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
                        // Set to, from, message, etc.
                        $this->email->from('no-reply@cpact.embrapa.br', 'Me');
                        $this->email->reply_to('no-reply@cpact.embrapa.br', 'Me');
                        $this->email->subject("Erro PlenUS: ".$sensor[0]['servidorborda_nome']." - ".$sensor[0]['nome']);
                        $this->email->message("Erro PlenUS: Sensor desconectado \n\nServidor de Borda: ".$sensor[0]['servidorborda_nome']." \nSensor: ".$sensor[0]['nome']." \nData coleta: ".$content['datacoleta']." \nValor coletado: ".$content['valorcoletado']."\n\n\n");

                        foreach ($usuarios as $usuario) {
                            $this->email->to($usuario['email']);
                            $result = $this->email->send();
                        }

                        //se não retornou inc
                        $message = ['status' => FALSE,
                        'message' => 'Dados não registrados com sucesso. Erro PlenUS: Sensor desconectado. Servidor de Borda: '.$sensor[0]['servidorborda_nome'].' Sensor: '.$sensor[0]['nome'].' Data coleta: '.$content['datacoleta'].' Valor coletado: '.$content['valorcoletado'].'. E-mails enviados.'];
                        // retorna 409 (conflito)
                        $this->set_response($message, REST_Controller::HTTP_CONFLICT);
                    }
                }
            }
        }
    }

    public function index_put(){
        // Requisições sem ID - lista todos os elementos
        $id = $this->_args['id']; // precisei utilizar esse metodo para obter os paramentros pois a biblioteca não funciona se enviados por PUT
        //$id = $this->put('id');
        if ($id === NULL){
            //se não veio, retorna erro 204 (no content)
            $message = ['status' => FALSE,
                        'message' => 'No publication was found'];
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }else{
            // Requisições com ID - lista informações do elemento
            $content = $this->_args['content']; // precisei utilizar esse metodo para obter os paramentros pois a biblioteca não funciona se enviados por PUT
            if ($content === NULL){
                //se não veio, retorna erro 204 (no content)
                $message = ['status' => FALSE,
                            'message' => 'No content was found'];
                $this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
            }else{
                //se veio, o framework já transforma o json para array associativo com os dados
                //salva no objeto do model
                $this->M_publicacoes->setPublicacaoId($id);
                $this->M_publicacoes->setPublicacaoSensor($content['sensor_id']);
                $this->M_publicacoes->setPublicacaoDataColeta($content['datacoleta']);
                $this->M_publicacoes->setPublicacaoDataPublicacao($content['datapublicacao']);
                $this->M_publicacoes->setPublicacaoValorColetado($content['valorcoletado']);
                if ($this->M_publicacoes->salvar() == "alt"){
                    //se retornou alt, está salvo no banco
                    $message = "Dados registrados com sucesso!";
                    // retorna 200 (OK)
                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
                else {
                    //se não retornou alt
                    $message = "Dados não registrados com sucesso!";
                    // retorna 409 (conflito)
                    $this->set_response($message, REST_Controller::HTTP_CONFLICT);
                }
            }
        }        
    }

    public function index_delete(){
        // Obtem o paramentro id passado na url através de GET, pois a função DELETE e PUT da biblioteca não funcionam.
        $id = $this->get('id');
        if ($id !== NULL || $id != ""){
            //se o id estiver setado, salva o id em um objeto do model ambinete e aciona metodo de excluir
            $this->M_publicacoes->setPublicacaoId($id);  
            $this->M_publicacoes->excluir();

            $message = "Registro(s) excluído(s) com sucesso!";
            $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                    'status' => FALSE,
                    'message' => 'No publication was found'
                ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}