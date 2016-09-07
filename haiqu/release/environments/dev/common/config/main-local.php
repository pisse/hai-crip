<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=rdsyjij2uuqmbvr.mysql.rds.aliyuncs.com;dbname=hq',
            'username' => 'allchange',
            'password' => 'telen030KEVIN',
            'tablePrefix' => 'tb_',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
           // 'hostname' => '10.168.23.81',
             'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
    ],
];
