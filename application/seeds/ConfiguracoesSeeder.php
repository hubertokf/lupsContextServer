<?php

use Phinx\Seed\AbstractSeed;

class ConfiguracoesSeeder extends AbstractSeed{
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
                'titulo' => 'Servidor de Contexto', 
                'img_cabecalho' => 'network-782707_640.png', 
                'img_projeto' => 'logotipo_lups_descricao.png')
        );

        $posts = $this->table('configuracoes');
        $posts->insert($data)
              ->save();
    }
}
