<?php

use Phinx\Seed\AbstractSeed;

class PerfisusuariosSeeder extends AbstractSeed{
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
                'perfilusuario_id' => 1,
                'nome' => 'Administrador',
                'descricao' => 'Administrador'),
            array(
                'perfilusuario_id' => 10,
                'nome' => 'Agendador',
                'descricao' => 'Agendador'),
            array(
                'perfilusuario_id' => 2,
                'nome' => 'Super Administrador',
                'descricao' => 'Super Administrador'),
            array(
                'perfilusuario_id' => 11,
                'nome' => 'Visualizador',
                'descricao' => 'asdf')
        );

        $posts = $this->table('perfisusuarios');
        $posts->insert($data)
              ->save();
    }
}
