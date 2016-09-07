<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@mobile', dirname(dirname(__DIR__)) . '/mobile');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');


/**
 * 设置别名，即可以通过Yii::$container->get('userService')的方式获得对应的service对象
 * 当然也可以通过构造函数注入到成员变量中
 */
Yii::$container->set('userService', 'common\services\UserService');
Yii::$container->set('accountService', 'common\services\AccountService');
Yii::$container->set('userContactService', 'common\services\UserContactService');
Yii::$container->set('payService', 'common\services\PayService');
Yii::$container->set('llPayService', 'common\services\LLPayService');
Yii::$container->set('buildingService', 'common\services\BuildingService');
Yii::$container->set('zmopService', 'common\services\ZmopService');
Yii::$container->set('fkbService', 'common\services\FkbService');
Yii::$container->set('jxlService', 'common\services\JxlService');
Yii::$container->set('loanService', 'common\services\LoanService');
Yii::$container->set('loanPersonBadInfoService', 'common\services\LoanPersonBadInfoService');
Yii::$container->set('haoDaiService', 'common\services\HaoDaiService');
Yii::$container->set('financialCommonService', 'common\services\FinancialCommonService');
Yii::$container->set('financialService', 'common\services\FinancialService');
Yii::$container->set('yeePayService', 'common\services\YeePayService');
Yii::$container->set('orderService', 'common\services\OrderService');
Yii::$container->set('installmentShopService', 'common\services\InstallmentShopService');
Yii::$container->set('contractService', 'common\services\ContractService');
Yii::$container->set('tdService', 'common\services\TdService');
Yii::$container->set('loanPersonInfoService', 'common\services\LoanPersonInfoService');
Yii::$container->set('repaymentService', 'common\services\RepaymentService');
Yii::$container->set('loanBlackListService', 'common\services\LoanBlackListService');

