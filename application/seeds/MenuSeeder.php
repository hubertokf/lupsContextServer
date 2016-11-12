<?php

use Phinx\Seed\AbstractSeed;

class MenuSeeder extends AbstractSeed{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run(){
        $data = array(
            array(
                'nome' => 'Administração',
                'parente' => NULL,
                'caminho' => NULL, 
                'ordem' => 9),
            array(
                'nome' => 'Início',
                'parente' => '',
                'caminho' => 'CI_inicio',
                'ordem' => 1),
            array(
                'nome' => 'Servidor de Contexto',
                'parente' => NULL, 
                'caminho' => 'cadastros/CI_servidorcontexto',
                'ordem' => 2),
            array(
                'nome' => 'Sensores',
                'parente' => NULL,
                'caminho' => 'cadastros/CI_sensores',
                'ordem' => 7),
            array(
                'nome' => 'Agendamento',
                'parente' => '',
                'caminho' => 'agenda/CI_agenda',
                'ordem' => 8),
            array(
                'nome' => 'Tipo de sensores',
                'parente' => '3', 
                'caminho' => 'cadastros/CI_tipossensores',
                'ordem' => 11),
            array(
                'nome' => 'Servidores de Borda',
                'parente' => NULL, 
                'caminho' => 'cadastros/CI_servidoresborda', 
                'ordem' => 4),
            array(
                'nome' => 'Fabricantes',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_fabricantes', 
                'ordem' => 14),
            array(
                'nome' => 'Publicações Realizadas',
                'parente' =>  '3', 
                'caminho' => 'cadastros/CI_publicacoes', 
                'ordem' => 16),
            array(
                'nome' => 'Perfis',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_perfisusuarios', 
                'ordem' => 18),
            array(
                'nome' => 'Usuários',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_usuarios', 
                'ordem' => 19),
            array(
                'nome' => 'Menus',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_menus', 
                'ordem' => 17),
            array(
                'nome' => 'Visualizar',
                'parente' => '5', 
                'caminho' => 'agenda/CI_agenda/selecionar', 
                'ordem' => 23),
            array(
                'nome' => 'Ambientes',
                'parente' => NULL, 
                'caminho' => 'cadastros/CI_ambientes', 
                'ordem' => 6),
            array(
                'nome' => 'Relatórios',
                'parente' => '5', 
                'caminho' => 'agenda/CI_agenda/relatorio', 
                'ordem' => 22),
            array(
                'nome' => 'Gateway',
                'parente' => '13', 
                'caminho' => 'cadastros/CI_gateways', 
                'ordem' => 5),
            array(
                'nome' => 'Contexto de Interesse',
                'parente' => '2', 
                'caminho' => 'cadastros/CI_contextosinteresse', 
                'ordem' => 0),
            array(
                'nome' => 'Configurações',
                'parente' =>  '6', 
                'caminho' => 'configuracoes/CI_configuracoes/', 
                'ordem' => 0),
            array(
                'nome' => 'Regra de Contexto',
                'parente' => '2', 
                'caminho' => 'cadastros/CI_regras_context', 
                'ordem' => 2),
            array(
                'nome' => 'Regra de Agendamento',
                'parente' => '13', 
                'caminho' => 'cadastros/CI_regras_agendamento', 
                'ordem' => 3),
            array(
                'nome' => 'Regra de Borda',
                'parente' => '13', 
                'caminho' => 'cadastros/CI_regras_sb', 
                'ordem' => 4)
        );

        $posts = $this->table('menus');
        $posts->insert($data)
              ->save();
    }
}
