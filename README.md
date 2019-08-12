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

OBS: Mesmo alterando a senha aqui, pode dar erro de acesso no DB.

Então fazer isso:

sudo -u postgres psql

ALTER USER postgres PASSWORD '<senha>';

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
