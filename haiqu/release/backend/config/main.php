<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/backend/config/params-local.php')
);


return [
    'id' => 'app-backend',
    'name' => '嗨去',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'main/index',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'view' => [
            'class' => 'backend\components\View',
        ],
        'user' => [
            'identityClass' => 'backend\models\AdminUser',
            'loginUrl' => ['main/login'],
        ],
        'session' => [
            'timeout' => 3 * 3600,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
			// ------- 全局通用日志配置 begin -------
                [
                    'class' => 'yii\mongodb\log\MongoDbTarget',
                    'levels' => ['error', 'warning'],
                    'logCollection' => 'hq_backend_error',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\mongodb\log\MongoDbTarget',
                    'levels' => ['info', 'trace'],
                    'categories' => ['application'],
                    'logCollection' => 'hq_backend_info',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                ],
                // ------- 全局通用日志配置 end -------
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],

        'aliases' => [
            'class' => 'callmez\wechat\sdk\Wechat',
            '@callmez\wechat\sdk' => '@vendor/callmez/yii2-wechat-sdk',
        ],
        'wechat' => [
            'class' => 'callmez\wechat\sdk\Wechat',
            'appId' => 'wxca2b9f58fda71155',   //测试公众号
            'appSecret' => '27acff528a646a977c7cc8a48ee06547',
            'token' => 'weixin',

        ],

    ],
    'params' => $params,

];
