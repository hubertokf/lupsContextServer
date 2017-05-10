# embrapa.contextServer

Para instalar o Servidor de Contexto basta:
------------------
* cd vá_até_a_pasta_do_projeto/
* php index install step1.
  * Obs1: está em andamento;

Fazer migração e inserção de dados báscios no BD sem o uso do install:
------------------
* php vender/bin/phinx migrate;
* php vendor/bin/phinx seed:run
