<?php

use Phinx\Migration\AbstractMigration;

class CreateSensoresTable extends AbstractMigration{
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
        $table = $this->table('sensores', array('id' => 'sensor_id'));
        $table->addColumn('nome', 'string')
              ->addColumn('descricao', 'string', array('null' => true))
              ->addColumn('modelo', 'string', array('null' => true))
              ->addColumn('precisao', 'float', array('null' => true, 'default' => '1'))
              ->addColumn('valormin', 'float', array('null' => true))
              ->addColumn('valormax', 'float', array('null' => true))
              ->addColumn('valormin_n', 'float', array('null' => true))
              ->addColumn('valormax_n', 'float', array('null' => true))
              ->addColumn('inicio_luz', 'datetime', array('null' => true))
              ->addColumn('fim_luz', 'datetime', array('null' => true))
              ->addColumn('uuid', 'uuid', array('null' => true))
              ->addColumn('status', 'boolean', array('default' => 'true'))
              ->addColumn('fabricante_id', 'integer', array('null' => true))
              ->addColumn('tiposensor_id', 'integer', array('null' => true))
              ->addColumn('ambiente_id', 'integer', array('null' => true))
              ->addColumn('gateway_id', 'integer')
              ->addColumn('servidorborda_id', 'integer')

              ->addForeignKey('ambiente_id', 'ambientes', 'ambiente_id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->addForeignKey('fabricante_id', 'fabricantes', 'fabricante_id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->addForeignKey('gateway_id', 'gateways', 'gateway_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('servidorborda_id', 'servidoresborda', 'servidorborda_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('tiposensor_id', 'tipossensores', 'tiposensor_id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->create();        
    }
}
