<?php
return  [
            'dsn'       =>  'mysql:host=localhost;dbname=databasename',
            'username'  =>  'username',
            'password'  =>  'password',
            'options'   =>  [
                                \PDO::MYSQL_ATTR_INIT_COMMAND   => 'SET NAMES utf8',
                                \PDO::ATTR_DEFAULT_FETCH_MODE   => \PDO::FETCH_OBJ,
                                \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
                                \PDO::ATTR_EMULATE_PREPARES     => false
                            ]
        ];