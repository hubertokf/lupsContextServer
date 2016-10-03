<?php

use Phinx\Seed\AbstractSeed;

class RelmenuperfilSeeder extends AbstractSeed{
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
                'menu_id' => 1,
                'perfilusuario_id' => 10),
            array(
                'menu_id' => 5,
                'perfilusuario_id' => 10),
            array(
                'menu_id' => 21,
                'perfilusuario_id' => 10),
            array(
                'menu_id' => 24,
                'perfilusuario_id' => 10),
            array(
                'menu_id' => 6,
                'perfilusuario_id' => 10),
            array(
                'menu_id' => 17,
                'perfilusuario_id' => 10),
            array(
                'menu_id' => 1,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 2,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 37,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 41,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 3,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 11,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 16,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 5,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 21,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 24,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 6,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 14,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 17,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 18,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 19,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 39,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 40,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 13,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 25,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 42,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 43,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 22,
                'perfilusuario_id' => 2),
            array(
                'menu_id' => 1,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 2,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 37,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 41,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 3,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 11,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 16,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 5,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 21,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 24,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 6,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 14,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 17,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 18,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 19,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 39,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 40,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 13,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 25,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 42,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 43,
                'perfilusuario_id' => 1),
            array(
                'menu_id' => 22,
                'perfilusuario_id' => 1)
        );
        
        $posts = $this->table('relmenuperfil');
        $posts->insert($data)
              ->save();
    }
}
