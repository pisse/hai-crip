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
    ],
];
