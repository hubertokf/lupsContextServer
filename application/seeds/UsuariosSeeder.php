<?php

use Phinx\Seed\AbstractSeed;

class UsuariosSeeder extends AbstractSeed{
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
                'username' =>'adenauer', 
                'password' => 'plenus2luz', 
                'email' => 'adenauer@inf.ufpel.edu.br', 
                'nome' => 'Adenauer', 
                'telefone' => '', 
                'celular' => '5391123478', 
                'perfilusuario_id' => 2,
                'token' => 'cfb281929c3574091ad2a7cf80274421e6a87c58'),
            array(
                'username' =>'hubertokf', 
                'password' => '99766330', 
                'email' => 'betinhoh@gmail.com', 
                'nome' => 'Huberto Kaiser Filho', 
                'telefone' => '5330277169', 
                'celular' => '5381177468', 
                'perfilusuario_id' => 2,
                'token' => 'cfb281929c3574091ad2a7cf80274421e6a87c59'),
            array(
                'username' =>'trcarvalho', 
                'password' => 'batata', 
                'email' => 'trcarvalho@inf.ufpel.edu.br', 
                'nome' => 'Tainã Carvalho', 
                'telefone' => '55555555555', 
                'celular' => '55555555555', 
                'perfilusuario_id' => 2,
                'token' => 'cfb281929c3574091ad2a7cf80274421e6a87c57')
        );

        $posts = $this->table('usuarios');
        $posts->insert($data)
              ->save();
    }
}
