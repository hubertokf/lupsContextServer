<?php

use Phinx\Migration\AbstractMigration;

class CreateRelcontextointeresseTable extends AbstractMigration{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(){
        $table = $this->table('relcontextointeresse', array('id' => false, 'primary_key' => array('sensor_id', 'contextointeresse_id')));
        $table->addColumn('sensor_id', 'integer')
              ->addColumn('contextointeresse_id', 'integer')
              ->addColumn('ativaregra', 'boolean', array('default' => 'false'))
              ->addForeignKey('contextointeresse_id', 'contextosinteresse', 'contextointeresse_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('sensor_id', 'sensores', 'sensor_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->create();
    }
}
