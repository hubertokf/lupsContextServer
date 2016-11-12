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
class Ambientes extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key

        //Load Models
        $this->load->model('M_ambientes');
        $this->load->model('M_gateways');
        $this->load->model('M_usuarios');
        $this->load->model('M_sensores');
    }
    // Requisições GET enviadas para o index.
    public function index_get(){
        // Requisições sem ID - lista todos os elementos
        $id = $this->get('id');
        if ($id === NULL){
            // Pega ambientes do banco através do model ambiente
            $ambientes = $this->M_ambientes->pesquisar('', array(), '', 0, 'asc', FALSE)->result_array();

            if ($ambientes){
                // Converte os dados adquiridos do banco (array) para Json
                $ambientes_json = json_encode($ambientes, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($ambientes_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No ambients were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
        // Requisições com ID - lista informações do elemento
            $ambiente = $this->M_ambientes->selecionar($id)->result_array();

            if ($ambiente){
                // Converte os dados adquiridos do banco (array) para Json
                $ambiente_json = json_encode($ambiente, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($ambiente_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No ambient was found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post(){
        $content = $this->post('content');
        if ($content === NULL){

        }
    }

    public function index_put(){
        // Requisições sem ID - lista todos os elementos
        $id = $this->get('id');
        if ($id === NULL){

        }else{
        // Requisições com ID - lista informações do elemento
            $content = $this->post('content');
            if ($content === NULL){

            }
        }
        
    }

    public function index_delete(){
        $id = $this->get('id');
        if ($id != NULL){
            if ($id==""){

                if(isset($_POST["item"])) {
                    $this->M_ambientes->setAmbienteId($_POST["item"]);   
                    $this->M_ambientes->excluir();
                }
            }
            else{
                $this->M_ambientes->setAmbienteId($id);  
                $this->M_ambientes->excluir();
            }
            $this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
            $this->pesquisa();
        }
    }
}