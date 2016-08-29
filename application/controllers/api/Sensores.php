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
class Sensores extends REST_Controller {

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
        $this->load->model('M_ambiente');
        $this->load->model('M_fabricante');
        $this->load->model('M_gateway');
        $this->load->model('M_sensor');
        $this->load->model('M_servidorborda');
        $this->load->model('M_tipo_sensor');
    }
    // Requisições GET enviadas para o index.
    public function index_get(){
        // Requisições sem ID - lista todos os elementos
        $id = $this->get('id');
        if ($id === NULL){
            // Pega sensores do banco através do model sensores
            $sensores = $this->M_sensor->pesquisar('', array(), '', 0, 'asc', FALSE)->result_array();

            if ($sensores){
                // Converte os dados adquiridos do banco (array) para Json
                $sensores_json = json_encode($sensores, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($sensores_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No sensors were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
        // Requisições com ID - lista informações do elemento
            $sensor = $this->M_sensor->selecionar($id)->result_array();
            if ($sensor){
                // Converte os dados adquiridos do banco (array) para Json
                $sensor_json = json_encode($sensor, JSON_UNESCAPED_UNICODE);
                // Define a resposta e finaliza com codigo 200 - OK
                $this->response($sensor_json, REST_Controller::HTTP_OK);
            }else{
                // Define a resposta de ERRO e finaliza com codigo 404 - Não encontrado (NOT_FOUND)
                $this->response([
                    'status' => FALSE,
                    'message' => 'No sensor was found'
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
            $this->M_sensor->setSensorNome($content["nome"]);
            $this->M_sensor->setSensorDesc($content["descricao"]);
            $this->M_sensor->setSensorModelo($content["modelo"]);
            $this->M_sensor->setSensorPrecisao(isset($content["precisao"]) ? $content["precisao"] : null);

            $this->M_sensor->setSensorValorMin(isset($content["valormin"]) ? $content["valormin"] : null);
            $this->M_sensor->setSensorValorMax(isset($content["valormax"]) ? $content["valormax"] : null);

            $this->M_sensor->setSensorValorMin_n(isset($content["valormin_n"]) ? $content["valormin_n"] : null);
            $this->M_sensor->setSensorValorMax_n(isset($content["valormax_n"]) ? $content["valormax_n"] : null);

            $this->M_sensor->setSensorInicioLuz(isset($content["inicio_luz"]) ? $content["inicio_luz"] : null);
            $this->M_sensor->setSensorFimLuz(isset($content["fim_luz"]) ? $content["fim_luz"] : null);

            $this->M_sensor->setSensorFabricante(isset($content["fabricante_id"]) ? $content["fabricante_id"] : null);
            $this->M_sensor->setSensorTipo($content["tiposensor_id"]);
            $this->M_sensor->setSensorAmbiente(isset($content["ambiente_id"]) ? $content["ambiente_id"] : null);
            $this->M_sensor->setSensorGateway($content["gateway_id"]);
            $this->M_sensor->setSensorServidorBorda($content["servidorborda_id"]);
            $this->M_sensor->setSensorStatus($content["status"]);
            //salva o model no banco
            if ($this->M_sensor->salvar() == "inc"){
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
                        'message' => 'No sensor was found'];
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
                $this->M_sensor->setSensorId($id);
                $this->M_sensor->setSensorNome($content["nome"]);
                $this->M_sensor->setSensorDesc($content["descricao"]);
                $this->M_sensor->setSensorModelo($content["modelo"]);
                $this->M_sensor->setSensorPrecisao(isset($content["precisao"]) ? $content["precisao"] : null);

                $this->M_sensor->setSensorValorMin(isset($content["valormin"]) ? $content["valormin"] : null);
                $this->M_sensor->setSensorValorMax(isset($content["valormax"]) ? $content["valormax"] : null);

                $this->M_sensor->setSensorValorMin_n(isset($content["valormin_n"]) ? $content["valormin_n"] : null);
                $this->M_sensor->setSensorValorMax_n(isset($content["valormax_n"]) ? $content["valormax_n"] : null);

                $this->M_sensor->setSensorInicioLuz(isset($content["inicio_luz"]) ? $content["inicio_luz"] : null);
                $this->M_sensor->setSensorFimLuz(isset($content["fim_luz"]) ? $content["fim_luz"] : null);

                $this->M_sensor->setSensorFabricante(isset($content["fabricante_id"]) ? $content["fabricante_id"] : null);
                $this->M_sensor->setSensorTipo($content["tiposensor_id"]);
                $this->M_sensor->setSensorAmbiente(isset($content["ambiente_id"]) ? $content["ambiente_id"] : null);
                $this->M_sensor->setSensorGateway($content["gateway_id"]);
                $this->M_sensor->setSensorServidorBorda($content["servidorborda_id"]);
                $this->M_sensor->setSensorStatus($content["status"]);
                if ($this->M_sensor->salvar() == "alt"){
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
            $this->M_sensor->setSensorId($id);  
            $this->M_sensor->excluir();

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