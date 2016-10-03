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
                'menu_id' => 6,
                'nome' => 'Administração',
                'parente' => NULL,
                'caminho' => NULL, 
                'ordem' => 9),
            array(
                'menu_id' => 1,
                'nome' => 'Início',
                'parente' => '',
                'caminho' => 'CI_inicio',
                'ordem' => 1),
            array(
                'menu_id' => 2,
                'nome' => 'Servidor de Contexto',
                'parente' => NULL, 
                'caminho' => 'cadastros/CI_servidorcontexto',
                'ordem' => 2),
            array(
                'menu_id' => 3,
                'nome' => 'Sensores',
                'parente' => NULL,
                'caminho' => 'cadastros/CI_sensores',
                'ordem' => 7),
            array(
                'menu_id' => 5,
                'nome' => 'Agendamento',
                'parente' => '',
                'caminho' => 'agenda/CI_agenda',
                'ordem' => 8),
            array(
                'menu_id' => 11,
                'nome' => 'Tipo de sensores',
                'parente' => '3', 
                'caminho' => 'cadastros/CI_tipossensores',
                'ordem' => 11),
            array(
                'menu_id' => 13,
                'nome' => 'Servidores de Borda',
                'parente' => NULL, 
                'caminho' => 'cadastros/CI_servidoresborda', 
                'ordem' => 4),
            array(
                'menu_id' => 14,
                'nome' => 'Fabricantes',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_fabricantes', 
                'ordem' => 14),
            array(
                'menu_id' => 16,
                'nome' => 'Publicações Realizadas',
                'parente' =>  '3', 
                'caminho' => 'cadastros/CI_publicacoes', 
                'ordem' => 16),
            array(
                'menu_id' => 17,
                'nome' => 'Perfis',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_perfisusuarios', 
                'ordem' => 18),
            array(
                'menu_id' => 18,
                'nome' => 'Usuários',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_usuarios', 
                'ordem' => 19),
            array(
                'menu_id' => 19,
                'nome' => 'Menus',
                'parente' => '6', 
                'caminho' => 'cadastros/CI_menus', 
                'ordem' => 17),
            array(
                'menu_id' => 21,
                'nome' => 'Visualizar',
                'parente' => '5', 
                'caminho' => 'agenda/CI_agenda/selecionar', 
                'ordem' => 23),
            array(
                'menu_id' => 22,
                'nome' => 'Ambientes',
                'parente' => NULL, 
                'caminho' => 'cadastros/CI_ambientes', 
                'ordem' => 6),
            array(
                'menu_id' => 24,
                'nome' => 'Relatórios',
                'parente' => '5', 
                'caminho' => 'agenda/CI_agenda/relatorio', 
                'ordem' => 22),
            array(
                'menu_id' => 25,
                'nome' => 'Gateway',
                'parente' => '13', 
                'caminho' => 'cadastros/CI_gateways', 
                'ordem' => 5),
            array(
                'menu_id' => 37,
                'nome' => 'Contexto de Interesse',
                'parente' => '2', 
                'caminho' => 'cadastros/CI_contextosinteresse', 
                'ordem' => 0),
            array(
                'menu_id' => 39,
                'nome' => 'Personalizar perfil',
                'parente' =>  '6', 
                'caminho' => 'configuracoes/CI_configuracoes/personaliza', 
                'ordem' => 5),
            array(
                'menu_id' => 40,
                'nome' => 'Configurações Gerais',
                'parente' =>  '6', 
                'caminho' => 'configuracoes/CI_configuracoes/geral', 
                'ordem' => 0),
            array(
                'menu_id' => 41,
                'nome' => 'Regra de Contexto',
                'parente' => '2', 
                'caminho' => 'cadastros/CI_regras_context', 
                'ordem' => 2),
            array(
                'menu_id' => 42,
                'nome' => 'Regra de Agendamento',
                'parente' => '13', 
                'caminho' => 'cadastros/CI_regras_agendamento', 
                'ordem' => 3),
            array(
                'menu_id' => 43,
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
