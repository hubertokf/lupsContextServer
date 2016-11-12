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
                'name' => 'titulo',
                'value' => 'Servidor de Contexto'),
            array(
                'name' => 'titulo_projeto',
                'value' => 'EXEHDA'),
            array(
                'name' => 'img_cabecalho',
                'value' => 'network-782707_640.png'),
            array(
                'name' => 'img_projeto',
                'value' => 'logotipo_lups_descricao.png'),
            array(
                'name' => 'cor_predominante',
                'value' => '#142b55'),
            array(
                'name' => 'email_from',
                'value' => 'teste@gmail.com'),
            array(
                'name' => 'email_host',
                'value' => 'ssl://smtp.gmail.com'),
            array(
                'name' => 'email_port',
                'value' => '465'),
            array(
                'name' => 'email_user',
                'value' => 'mmadrugadeazevedo'),
            array(
                'name' => 'email_pass',
                'value' => 'hacker22')
        );

        $posts = $this->table('configuracoes');
        $posts->insert($data)
              ->save();
    }
}