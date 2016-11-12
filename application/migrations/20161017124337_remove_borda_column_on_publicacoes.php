<?php

use Phinx\Migration\AbstractMigration;

class RemoveBordaColumnOnPublicacoes extends AbstractMigration{

    /**
     * Migrate up.
     */
    public function up(){
        $table = $this->table('publicacoes');
        $table->removeColumn('servidorborda_id')
              ->save();
    }
}
