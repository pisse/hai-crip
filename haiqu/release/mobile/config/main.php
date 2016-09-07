<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/mobile/config/params-local.php')
);


return [
    'id' => 'mobile-backend',
    'name' => '嗨去',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'main/index',
    'controllerNamespace' => 'mobile\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            // 允许使用auth_key来自动登录
            'enableAutoLogin' => true,
            // 设为null避免跳转
            'loginUrl' => null,
        ],
        /*'session' => [
            // 使用redis做session
            'class' => 'yii\redis\Session',
            'redis' => 'redis',
            // 与后台区分开会话key，保证前后台能同时单独登录
            'name' => 'SESSIONID',
            'timeout' => 20 * 24 * 3600,
            'cookieParams' => ['lifetime' => 12 * 3600, 'httponly' => true, 'domain' => YII_ENV_PROD ? '.668ox.com' : ''],
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                // ------- 全局通用日志配置 begin -------

                // ------- 全局通用日志配置 end -------
            ]
        ],
        // 下面是扩展了系统的组件
        'errorHandler' => [
            'class' => 'mobile\components\ErrorHandler',
        ],
        'request' => [
            'class' => 'mobile\components\Request',
        ],
        'view' => [
            'class' => 'mobile\components\View',
        ],
    ],
    'params' => $params,
];
