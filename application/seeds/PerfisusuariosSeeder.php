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
                'nome' => 'Super Administrador',
                'descricao' => 'Super Administrador',
                'superAdm' => true)
        );

        $posts = $this->table('perfisusuarios');
        $posts->insert($data)
              ->save();
    }
}
