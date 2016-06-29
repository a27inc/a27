A-27, Inc. ZF2 Application
=======================

Introduction
------------
This application uses the ZF2 MVC layer and module systems.  Functionality is built for A-27 Inc. -- a real estate investment company and includes:
User, Authentication, RBAC, Properties, Incomes, Expenses, Financial Reports, Investors, Dividends, Landlords, and Tenants.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `update` command:

    curl -s https://getcomposer.org/installer | php --
    php composer.phar update

Alternately, clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    git clone https://github.com/akrause414/a27.git
    cd a27
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/a27-project/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/a27-project/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
                Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>
