<?php

use Phinx\Migration\AbstractMigration;

class CreatePermissoesTable extends AbstractMigration{
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
        $table = $this->table('permissoes', array('id' => 'permissao_id'));
        $table->addColumn('usuario_id', 'integer')
              ->addColumn('contextointeresse_id', 'integer', array('null' => true))
              ->addColumn('sensor_id', 'integer', array('null' => true))
              ->addColumn('ambiente_id', 'integer', array('null' => true))
              ->addColumn('regra_id', 'integer', array('null' => true))
              ->addColumn('podeeditar', 'boolean', array('default' => 'false'))
              ->addColumn('recebeemail', 'boolean', array('default' => 'false'))
              ->addForeignKey('usuario_id', 'usuarios', 'usuario_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('contextointeresse_id', 'contextosinteresse', 'contextointeresse_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('sensor_id', 'sensores', 'sensor_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('ambiente_id', 'ambientes', 'ambiente_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('regra_id', 'regras', 'regra_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->create();
    }
}
