<?php

use Phinx\Migration\AbstractMigration;

class CreateRelmenuperfilTable extends AbstractMigration{
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
        $table = $this->table('relmenuperfil', array('id' => false, 'primary_key' => array('menu_id', 'perfilusuario_id')));
        $table->addColumn('menu_id', 'integer')
              ->addColumn('perfilusuario_id', 'integer')
              ->addForeignKey('menu_id', 'menus', 'menu_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->addForeignKey('perfilusuario_id', 'perfisusuarios', 'perfilusuario_id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
              ->create();
    }
}
