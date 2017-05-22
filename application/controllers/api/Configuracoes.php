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
class Configuracoes extends REST_Controller {

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
        $this->load->model('M_geral');
		$this->load->model('M_configuracoes');
		$this->load->model('M_usuarios');
		$this->load->model('M_perfisusuarios');
    }
    // Requisições GET enviadas para o index.
    public function index_get(){
        // Requisições sem ID - lista todos os elementos
        $id = $this->get('id');
        $configName = $this->get('name');
        if ($configName != NULL){
            // Pega config do banco através do model ambiente
            $config = $this->M_configuracoes->pesquisar(array('name'=>$configName))->result_array();

            if ($config){
                // Converte os dados adquiridos do banco (array) para Json
                $config_json = json_encode($config, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($config_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No config were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }elseif ($id === NULL){
            // Pega ambientes do banco através do model ambiente
            $config = $this->M_configuracoes->pesquisar(array())->result_array();

            if ($config){
                // Converte os dados adquiridos do banco (array) para Json
                $config_json = json_encode($config, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($config_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No config were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
        // Requisições com ID - lista informações do elemento
            $config = $this->M_configuracoes->selecionar($id)->result_array();

            if ($config){
                // Converte os dados adquiridos do banco (array) para Json
                $config_json = json_encode($config, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($config_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No config was found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    /*public function index_post(){
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
                    $this->M_configuracoes->setAmbienteId($_POST["item"]);   
                    $this->M_configuracoes->excluir();
                }
            }
            else{
                $this->M_configuracoes->setAmbienteId($id);  
                $this->M_configuracoes->excluir();
            }
            $this->dados["msg"] = "Registro(s) excluído(s) com sucesso!";
            $this->pesquisa();
        }
    }*/
}