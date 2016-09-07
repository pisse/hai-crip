<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                // ------- 全局通用日志配置 begin -------
                [
                    'class' => 'yii\mongodb\log\MongoDbTarget',
                    'levels' => ['error', 'warning'],
                    'exportInterval' => 1,
                    'logCollection' => 'hq_console_error',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\mongodb\log\MongoDbTarget',
                    'levels' => ['info', 'trace'],
                    'exportInterval' => 1,
                    'except' => ['yii*'],
                    'logCollection' => 'hq_console_info',
                    'logVars' => [],
                ]
                // ------- 全局通用日志配置 end -------
            ],
        ],
    ],
    'params' => $params,
];
