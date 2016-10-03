<?php

use Phinx\Migration\AbstractMigration;

class CreateConfiguracoesTable extends AbstractMigration{
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
        $table = $this->table('configuracoes', array('id' => 'configuracao_id'));
        $table->addColumn('usuario_id', 'integer', array('null' => true))
              ->addColumn('titulo', 'string')
              ->addColumn('img_cabecalho', 'string', array('null' => true))
              ->addColumn('img_projeto', 'string', array('null' => true))
              ->addColumn('cor_predominante', 'string', array('null' => true))
              ->addForeignKey('usuario_id', 'usuarios', 'usuario_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addIndex(array('usuario_id'), array('unique' => true))
              ->create();
    }
}
