<?php
return [
    'adminEmail' => 'admin@example.com',
    // 接口文档配置
    'apiList' => [
        [
            'class' => 'frontend\controllers\AppController',
            'label' => '全局接口',
        ],
        [
            'class' => 'frontend\controllers\UserController',
            'label' => '基本接口',
        ],
        [
            'class' => 'frontend\controllers\HomeController',
            'label' => '首页接口',
        ],
        [
            'class' => 'frontend\controllers\PersonCenterController',
            'label' => '个人中心',
        ],
    ],
    // 权限配置Controller,只能是后台backend命名空间下的
    'permissionControllers' => [
        'AttachmentController'=>'附件管理',

    ],

     //权限下的二级方法
     //附件管理
    'AttachmentController'=>[
        'actionList'=>'附件列表',
        'actionAdd'=>'添加附件',
        'actionDelete'=>'删除附件',
    ],
];
