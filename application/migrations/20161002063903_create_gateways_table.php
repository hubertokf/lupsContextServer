<?php

use Phinx\Migration\AbstractMigration;

class CreateGatewaysTable extends AbstractMigration{
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
        $table = $this->table('gateways', array('id' => 'gateway_id'));
        $table->addColumn('nome', 'string')
              ->addColumn('modelo', 'string', array('null' => true))
              ->addColumn('fabricante_id', 'integer', array('null' => true))
              ->addColumn('servidorborda_id', 'integer')
              ->addColumn('uuid', 'uuid', array('null' => true))
              ->addColumn('status', 'boolean', array('default' => 'true'))
              ->addForeignKey('servidorborda_id', 'servidoresborda', 'servidorborda_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->create();
    }
}
