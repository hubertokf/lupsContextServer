<?php

use Phinx\Seed\AbstractSeed;

class FabricantesSeeder extends AbstractSeed{
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
                'nome' =>'LUPS', 
                'endereco' => 'Rua Gomes Carneiro 1', 
                'telefone' => '5555555555555', 
                'url' => 'http://lups.inf.ufpel.edu.br', 
                'cidade' => 'Pelotas', 
                'estado' => 'RS', 
                'pais' => 'Brasil')
        );

        $posts = $this->table('fabricantes');
        $posts->insert($data)
              ->save();
    }
}
