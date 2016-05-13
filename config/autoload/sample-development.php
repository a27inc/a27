<?php
return [
    'db' => [
        'driver'         => 'Pdo',
        'username' => 'root',
        'password' => '',
        'dsn'            => 'mysql:dbname=a_27;host=localhost',
        'driver_options' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'your-user',
                    'password' => 'your-password',
                    'dbname'   => 'a_27',
                ]
            ]
        ]
    ],
];