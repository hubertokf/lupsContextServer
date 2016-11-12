<?php

use Phinx\Seed\AbstractSeed;

class KeysSeeder extends AbstractSeed{
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
                'level' => '10', 
                'ignore_limits' => '0', 
                'date_created' => '10', 
                'key' => 'cfb281929c3574091ad2a7cf80274421e6a87c58'),
            array(
                'level' => '10', 
                'ignore_limits' => '0', 
                'date_created' => '10', 
                'key' => 'cfb281929c3574091ad2a7cf80274421e6a87c59'),
            array(
                'level' => '10', 
                'ignore_limits' => '0', 
                'date_created' => '10', 
                'key' => 'cfb281929c3574091ad2a7cf80274421e6a87c57')
        );

        $posts = $this->table('keys');
        $posts->insert($data)
              ->save();
    }
}
