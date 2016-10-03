<?php

use Phinx\Migration\AbstractMigration;

class CreateUsuariosTable extends AbstractMigration{
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
        $table = $this->table('usuarios', array('id' => 'usuario_id'));
        $table->addColumn('username', 'string')
              ->addColumn('password', 'string')
              ->addColumn('cadastro', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
              ->addColumn('email', 'string')
              ->addColumn('nome', 'string')
              ->addColumn('telefone', 'string', array('null' => true))
              ->addColumn('celular', 'string', array('null' => true))
              ->addColumn('perfilusuario_id', 'integer')
              ->addColumn('token', 'string')
              ->addForeignKey('perfilusuario_id', 'perfisusuarios', 'perfilusuario_id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->addForeignKey('token', 'keys', 'key', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
              ->create();
    }
}
