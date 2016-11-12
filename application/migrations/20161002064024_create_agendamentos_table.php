<?php

use Phinx\Migration\AbstractMigration;

class CreateAgendamentosTable extends AbstractMigration{
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
        $table = $this->table('agendamentos', array('id' => 'agendamento_id'));
        $table->addColumn('datetimefinal', 'datetime')
              ->addColumn('descricao', 'string', array('null' => true))
              ->addColumn('usuario_id', 'integer')
              ->addColumn('ambiente_id', 'integer')
              ->addColumn('datetimeinicial', 'datetime')
              ->addForeignKey('usuario_id', 'usuarios', 'usuario_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('ambiente_id', 'ambientes', 'ambiente_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->create();

    }
}
