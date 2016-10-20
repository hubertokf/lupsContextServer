<?php

use Phinx\Migration\AbstractMigration;

class ChangingConfigurationsTableToGeneralConfigurations extends AbstractMigration
{
    public function up(){
        $table = $this->table('configuracoes');
        $table->removeColumn('usuario_id')
              ->removeColumn('titulo')
              ->removeColumn('img_cabecalho')
              ->removeColumn('img_projeto')
              ->removeColumn('cor_predominante')
              ->addColumn('name', 'string', array('null' => true))
              ->addColumn('value', 'string', array('null' => true))
              ->save();
    }
}
