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
            array('titulo' => 'Servidor de Contexto'),
            array('titulo_projeto' => 'EXEHDA'),
            array('img_cabecalho' => 'network-782707_640.png'),
            array('img_projeto' => 'logotipo_lups_descricao.png'),
            array('cor_predominante' => '#142b55'),
            array('email_host' => 'ssl://smtp.googlemail.com'),
            array('email_port' => '465'),
            array('email_user' => 'mmadrugadeazevedo'),
            array('email_pass' => 'hacker22')
        );

        $posts = $this->table('configuracoes');
        $posts->insert($data)
              ->save();
    }
}