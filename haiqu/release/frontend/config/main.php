<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/frontend/config/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => '嗨去',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'installment-shop',
    'components' => [
	    'urlManager' => [
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		    'rules' => [
		    	'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
		    ],
	    ],
        'user' => [
            'identityClass' => 'common\models\User',
            // 允许使用auth_key来自动登录
            'enableAutoLogin' => true,
            // 设为null避免跳转
            'loginUrl' => null,
        ],
        'session' => [
        	// 使用redis做session
        	'class' => 'yii\redis\Session',
        	'redis' => 'redis',
        	// 与后台区分开会话key，保证前后台能同时单独登录
        	'name' => 'SESSIONID',
        	'timeout' => 20 * 24 * 3600,
        	'cookieParams' => ['lifetime' => 12 * 3600, 'httponly' => true, 'domain' => YII_ENV_PROD ? '.668ox.com' : ''],
        ],
        'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
					// ------- 全局通用日志配置 begin -------
					
					// ------- 全局通用日志配置 end -------
				]
        ],
		// 下面是扩展了系统的组件
		'errorHandler' => [
			'class' => 'frontend\components\ErrorHandler',
		],
		'request' => [
			'class' => 'frontend\components\Request',
		],
        'view' => [
        	'class' => 'frontend\components\View',
        ],

        'wechat' => [
            'class' => 'callmez\wechat\sdk\Wechat',
            'appId' => 'wxca2b9f58fda71155',   //测试公众号
            'appSecret' => '27acff528a646a977c7cc8a48ee06547',
            'token' => 'weixin'
        ]
    ],
    'params' => $params,
];
