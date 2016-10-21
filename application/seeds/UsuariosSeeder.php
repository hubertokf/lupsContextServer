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
                'password' => '$2y$10$4bCfYZERne7B6FvkfPB93u9vKVFDzDaPQ6H2r/E09Lad4687eSjr6', 
                'email' => 'adenauer@inf.ufpel.edu.br', 
                'nome' => 'Adenauer', 
                'telefone' => '', 
                'celular' => '5391123478', 
                'perfilusuario_id' => 2,
                'token' => 'cfb281929c3574091ad2a7cf80274421e6a87c58'),
            array(
                'username' =>'hubertokf', 
                'password' => '$2y$10$qhfjTOr0/2M9UlFiu0WUber6QIB52m5seOjUkFnespb5J7ZXvwtGS', 
                'email' => 'betinhoh@gmail.com', 
                'nome' => 'Huberto Kaiser Filho', 
                'telefone' => '5330277169', 
                'celular' => '5381177468', 
                'perfilusuario_id' => 2,
                'token' => 'cfb281929c3574091ad2a7cf80274421e6a87c59'),
            array(
                'username' =>'trcarvalho', 
                'password' => '$2y$10$2EIOw3nabqxnPM8JLopoYuGCkCZ.SVaxL7nVj8iEEa/6DbL6sQGV6', 
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
