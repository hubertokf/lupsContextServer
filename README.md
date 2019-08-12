# LUPS Context Server

Step 1: Install Apache
------------------

sudo apt update
sudo apt install apache2


Step 2: Install Postgres
------------------
sudo apt install postgresql


Step 3: Install PHP
------------------
sudo apt install php libapache2-mod-php php-mcrypt

sudo apt install php-pgsql

sudo apt install php-curl

sudo apt install pgadmin3


Step 4: Alterar senha Postgres
------------------
sudo passwd postgres

su - postgres

psql

ALTER USER postgres PASSWORD '<senha>';
        
\q

Step 6: Ativar o mod_rewrite do apache
------------------

sudo nano /etc/apache2/apache2.conf

```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None # <---- ATENÇÂO
        Require all granted
</Directory>
```

Alterar para

```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All # <---- ATENÇÂO
        Require all granted
</Directory>
```

sudo a2enmod rewrite

sudo /etc/init.d/apache2 restart

Step 7: Clonando repositório
------------------

Acessar pasta do apache
cd /var/www/html
Clonar o repositório
git clone https://github.com/hubertokf/lupsContextServer.git


Step 8: Criando o DB
------------------

sudo su - postgres
psql
CREATE DATABASE contextserver OWNER postgres;
\q

php vendor/bin/phinx migrate -e development

php vendor/bin/phinx seed:run -e development


Step 9: Finalizando configurações 
------------------

Alterar senha no arquivo phinx.yml para a senha definida anteriormente
Exemplo: pass: '<senha>'

Alterar senha no arquivo /application/config/database.php para a senha definida anteriormente
Exemplo: 'password' => '<senha>'
        
Alterar base_url no arquivo /application/config/config.php para a url de acesso do sistema
Exemplo: 
Se a pasta de instalação for contextServer, e o domínio de acesso for http://exehda.ufpel.edu.br/. Então o base_url será http://exehda.ufpel.edu.br/contextServer


Step 10: (opcional) Instalação do Motor de Regras
------------------
* pasta_do_motor_de_regras/sudo python setup.py install
