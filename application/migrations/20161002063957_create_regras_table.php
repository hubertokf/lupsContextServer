<?php

use Phinx\Migration\AbstractMigration;

class CreateRegrasTable extends AbstractMigration{
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
        $table = $this->table('regras', array('id' => 'regra_id'));
        $table->addColumn('nome', 'string')
              ->addColumn('tipo', 'integer', array('default' => '1', 'comment' => '1->Script Python, 2->Regra de borda, 3->Regra de contexto, 4->regra de agendamento'))
              ->addColumn('arquivo_py', 'string', array('null' => true))
              ->addColumn('sensor_id', 'integer', array('null' => true))
              ->addColumn('status', 'boolean', array('default' => 'true'))
              ->addForeignKey('sensor_id', 'sensores', 'sensor_id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->create();
    }
}
