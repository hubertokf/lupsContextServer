<?php

use Phinx\Migration\AbstractMigration;

class CreatePersistenceTable extends AbstractMigration{
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
        $table = $this->table('persitencias', array('id' => 'persistencia_id'));
        $table->addColumn('metodo', 'string')
              ->addColumn('url_destino', 'string')
              ->addColumn('token', 'string')
              ->addColumn('dado', 'string')
              ->addColumn('criacao', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
              ->addColumn('ultimatentativa', 'datetime')
              ->create();
    }
}
