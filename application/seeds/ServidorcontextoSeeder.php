<?php

use Phinx\Seed\AbstractSeed;

class ServidorcontextoSeeder extends AbstractSeed{
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
                'servidorcontexto_id' => 9,
                'nome' => 'Servidor de Contexto', 
                'descricao' => 'Servidor de Contexto',
                'url' => 'http://localhost/contextServer')
        );
    
        $posts = $this->table('servidorcontexto');
        $posts->insert($data)
              ->save();
    }
}
