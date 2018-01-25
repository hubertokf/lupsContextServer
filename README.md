# LUPS Context Server

Step 1: Install Apache
------------------

sudo apt-get update
sudo apt-get install apache2


Step 2: Install Postgres
------------------
sudo aptitude install postgresql


Step 3: Install PHP
------------------
sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt

sudo apt-get install php5-pgsql

sudo apt-get install pgadmin3


Step 4: Alterar senha Postgres
------------------
sudo passwd postgres

su - postgres

PASSWORD 'batata'

OBS: Mesmo alterando a senha aqui, pode dar erro de acesso no DB.

Então fazer isso:

sudo -u postgres psql

ALTER USER postgres PASSWORD 'batata';

Step 5: Instalar CURL no php
------------------
sudo apt-get install php5-curl

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




Step 7: Criando o DB
------------------

sudo su - postgres
psql
CREATE DATABASE contextserver OWNER postgres;

psql +TAB	Verifica os DB existentes

php vendor/bin/phinx migrate -e development

php vendor/bin/phinx seed:run -e development


Step 8: (opcional) Instalação do Motor de Regras
------------------
* pasta_do_motor_de_regras/sudo python setup.py install
