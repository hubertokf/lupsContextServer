<?php

use Phinx\Migration\AbstractMigration;

class CreatePublicacoesTable extends AbstractMigration{
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
        $table = $this->table('publicacoes', array('id' => 'publicacao_id'));
        $table->addColumn('servidorborda_id', 'integer')
              ->addColumn('sensor_id', 'integer')
              ->addColumn('datacoleta', 'timestamp')
              ->addColumn('datapublicacao', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
              ->addColumn('valorcoletado', 'float')
              ->addForeignKey('servidorborda_id', 'servidoresborda', 'servidorborda_id', array('delete'=> 'NO_ACTION', 'update'=> 'CASCADE'))
              ->addForeignKey('sensor_id', 'sensores', 'sensor_id', array('delete'=> 'NO_ACTION', 'update'=> 'CASCADE'))
              ->create();
    }
}
