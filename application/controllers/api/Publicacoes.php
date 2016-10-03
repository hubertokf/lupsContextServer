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
        $this->load->model('M_servidoresborda');
        $this->load->model('M_sensores');
        $this->load->model('M_publicacoes');
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
        //verifica se o content da requisição veio
        if ($content === NULL || empty($content)){
            //se não veio, retorna erro 204 (no content)
            $message = ['status' => FALSE,
                        'message' => 'No content was found'];
            $this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
        }else{
            //se veio, o framework já transforma o json para array associativo com os dados

            //salva no objeto do model
            $this->M_publicacoes->setPublicacaoservidorborda($content['servidorborda_id']);
            $this->M_publicacoes->setPublicacaoSensor($content['sensor_id']);
            $this->M_publicacoes->setPublicacaoDataColeta($content['datacoleta']);
            $this->M_publicacoes->setPublicacaoDataPublicacao($content['datapublicacao']);
            $this->M_publicacoes->setPublicacaoValorColetado($content['valorcoletado']);
            //salva o model no banco
            if ($this->M_publicacoes->salvar() == "inc"){
                //se retornou inc, está salvo no banco
                $message = "Dados registrados com sucesso!";
                // retorna 201 (criado)
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }else{
                //se não retornou inc
                $message = "Dados não registrados com sucesso!";
                // retorna 409 (conflito)
                $this->set_response($message, REST_Controller::HTTP_CONFLICT);
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
                        'message' => 'No ambiente was found'];
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
                $this->M_publicacoes->setPublicacaoservidorborda($content['servidorborda_id']);
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