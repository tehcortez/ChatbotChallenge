# Chatbot Challenge Application

## Introduction

This is a Chatbot application using the Zend Framework MVC layer and module
systems. This application was designed to test my knowledge of web technologies and assess my ability to
create robust PHP web applications with attention to software architecture​ and security.

## Importing MySQL database

We need to create a new database. This is where the contents of the 'mysql/db.sql' file will be imported.

First, log in to the database as root or another user with sufficient privileges to create new databases:
```bash
$ mysql -u root -p
```

This will bring you into the MySQL shell prompt. 
Next, create a new database with the following command. In this example, the new database is called exchange:
```bash
CREATE DATABASE exchange;
```
You’ll see this output confirming that it was created.

```output
Query OK, 1 row affected (0.00 sec)
```
Then exit the MySQL shell by pressing CTRL+D. 
From the normal command line, you can import the dump file with the following command:
```bash
mysql -u username -p exchange < path/to/chatbot/mysql/db.sql
```
username is the username you can log in to the database with
newdatabase is the name of the freshly created database
db.sql is the data dump file to be imported, located in the current directory


## Environment-specific application configuration

Now we need to setup 'config/autoload/global.php' file with:

*MYSQL_DATABASE* = mysql database name;

*MYSQL_HOST* = host address to access your mysql server

*MYSQL_USER* = username to access your Mysql database

*MYSQL_PASSWORD* = password to access your Mysql database

*CURRENCYAPI_TOKEN* = token from your fixer.io account to access API

*PASSWORD_SALT* = any value that will fortify user password protection. If you change or lose this value, all user passwords that were stored with this salt will not work.

'config/autoload/global.php' file will look like this:
```code
return [
    'db' => [
        'dsn' => 'mysql:dbname=*MYSQL_DATABASE*;host=*MYSQL_HOST*',
        'driver' => 'Pdo',
        'username' => '*MYSQL_USER*',
        'password' => '*MYSQL_PASSWORD*',
        'driver_options' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        ],
    ],
    'currencyAPI' => '*CURRENCYAPI_TOKEN*',
    'salt' => '*PASSWORD_SALT*'
];
```

## Installation using Composer

The easiest way to install Chatbot project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

Once Composer is installed, to install dependencies for Chatbot app, run:

```bash
$ cd path/to/install
$ composer install
```

Once dependencies are installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ composer run --timeout 0 serve
# OR use the composer alias:
$ php -S 0.0.0.0:8080 -t public
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://127.0.0.1:8080/ OR http://localhost:8080/
- which will bring up Chatbot main page.

**Note:** The built-in CLI server is *for development only*.

## Chatbot instructions

All interactions are through chat. When the bot asks if she knows you:
```bash
$ yes
```
will proceed to login.
```bash
$ no
```
will proceed to creating a new account.

Bot will ask for login (Who are you?) and password.
If you are creating a new account, Bot will also ask for the default currency for that account.
Answer with a 3 digit code that represent that currency. Example:
```bash
$ USD
# OR
$ EUR
```

Account set and logged in, there are four main actions that you can do:
```bash
$ deposit
```
Will ask for the amount that you want to deposit and the currency that you want to use
```bash
$ balance
```
Will show the account balance in default account currency
```bash
$ withdraw
```
Will ask for the amount that you want to withdraw and the currency for converting
```bash
$ logout
```
Will logout from your account
If you don't logout, the bot will keep your session in storage and the next time you get to Chatbot page, Bot will remember you.

Chatbot will keep cache of the API response. This was implemented using zend-cache.
There are instructions for running Chatbot Unit Tests, powered by PHPUnit.

## Running Unit Tests

On the root directory of the chatbot app, run:

```bash
$ cd path/to/install
$ composer test
# OR use the composer alias:
$ ./vendor/bin/phpunit
```

All test cases are in:
/module/src/test
as stated in `phpunit.xml.dist` file

## Using docker-compose

This app provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

At this point, you can visit http://localhost:8080 to see the site running.

You can also run composer from the image. The container environment is named
"zf", so you will pass that value to `docker-compose run`:

```bash
$ docker-compose run zf composer install
```

## Apache setup

Create a configuration file in the Apache for the Chatbot Instalation.
```bash
sudo vi /etc/apache2/sites-available/zend.example.com.conf
```

Add the following content in the file. Make the necessary changes as per your directory structure and server name.
Point to the public/ directory of the Chatbot app and you should be ready to go!

```apache
<VirtualHost *:80>
    ServerName chatbotapp.localhost
    DocumentRoot /path/to/chatbotapp/public
    <Directory /path/to/chatbotapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```

Now enable the newly created website with the following command. Also, make sure you have rewrite modules enabled in Apache.

```bash
sudo a2enmod rewrite
sudo a2ensite chatbotapp.localhost
sudo systemctl restart apache2.service
```

Now you can access the Chatbot application with the configured domain in Apache


## Development mode

This app uses [zf-development-mode](https://github.com/zfcampus/zf-development-mode)
, and provides three aliases for consuming the script it ships with:

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

Remember to set `development-disable` for running this app on Production Environment

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.