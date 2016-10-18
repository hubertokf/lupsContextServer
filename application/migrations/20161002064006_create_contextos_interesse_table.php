<?php

use Phinx\Migration\AbstractMigration;

class CreateContextosInteresseTable extends AbstractMigration{
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
        $table = $this->table('contextosinteresse', array('id' => 'contextointeresse_id'));
        $table->addColumn('servidorcontexto_id', 'integer')
              ->addColumn('nome', 'string')
              ->addColumn('publico', 'boolean',array('default' => '1'))
              ->addColumn('regra_id', 'integer', array('null' => true))
              ->addForeignKey('servidorcontexto_id', 'servidorcontexto', 'servidorcontexto_id', array('delete'=> 'NO_ACTION', 'update'=> 'CASCADE'))
              ->addForeignKey('regra_id', 'regras', 'regra_id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->create();
    }
}
