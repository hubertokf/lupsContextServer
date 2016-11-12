<?php

use Phinx\Seed\AbstractSeed;

class TipossensoresSeeder extends AbstractSeed{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run(){
        $data = array(
            array(
                'nome' => 'Temperatura', 
                'descricao' => 'Sensor de Temperatura', 
                'unidade' => 'ºC',
                'tipo' => 1),
            array(
                'nome' => 'Umidade', 
                'descricao' => 'Sensor de Umidade', 
                'unidade' => '%UR',
                'tipo' => 1),
            array(
                'nome' => 'Estado de Evento', 
                'descricao' => 'Estado de Evento - Ligado ou Desligado', 
                'unidade' => 'L/D',
                'tipo' => 3),
            array(
                'nome' => 'Presença/Ausência Luz', 
                'descricao' => 'Presença ou Ausência de luz', 
                'unidade' => '%Luz',
                'tipo' => 3)
        );


    
        $posts = $this->table('tipossensores');
        $posts->insert($data)
              ->save();
    }
}
