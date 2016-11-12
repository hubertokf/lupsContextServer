<?php

use Phinx\Migration\AbstractMigration;

class CreateTipossensoresTable extends AbstractMigration{
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
        $table = $this->table('tipossensores', array('id' => 'tiposensor_id'));
        $table->addColumn('nome', 'string')
              ->addColumn('descricao', 'string', array('null' => true))
              ->addColumn('unidade', 'string')
              ->addColumn('tipo', 'integer', array('default' => '1', 'comment' => '1=numerico,2=string,3=booleano'))              
              ->addIndex(array('nome'), array('unique' => true))
              ->create();
    }
}
