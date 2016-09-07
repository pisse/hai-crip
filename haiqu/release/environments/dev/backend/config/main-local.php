<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Ns0-5LAjvfa6E9_U37TrWX0d7F9Sc-CY',
        ],
        
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

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '*.*.*.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
