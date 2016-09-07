<?php

namespace common\api;

use Yii;

class RedisQueue
{
    /**
     * redis队列key，都用"list_"前缀
     */
    const LIST_PROJECT_INVEST = 'list_project_invest';    // 投资成功队列key
    const LIST_USER_MESSAGE = 'list_user_message';      // 用户注册或绑卡成功队列key
    const LIST_PROJECT_CONTRACT = 'list_project_contract';    // 待生成合同队列key
    const LIST_PROJECT_CONTRACT_PROJECT = 'list_project_contract_project';    // 待生成合同队列key
    const LIST_CRAZY_SHAKE = 'list_crazy_shake';    // 疯狂摇消息队列
    const LIST_FAILURE = 'list_crazy_shake_failure';    // 疯狂摇发奖失败消息队列
    const LIST_PROJECT_CONTRACT_PROJECT_TRANSFER = 'list_project_contract_project_transfer';    //待生成转让合同队列key
    const LIST_FINISH_INDIANA = 'list_finish_indiana';    //一元夺宝
    const LIST_FINISH_PAY_PASSWORD = 'list_finish_pay_password'; //更改支付密码队列
    const LIST_USER_PAY_ORDER_BAOFU = 'list_user_pay_order_baofu'; // 实时轮询宝付轮询订单状态
    const LIST_USER_CHECK_PAY_ORDER_BAOFU = 'list_user_check_pay_order_baofu'; // 每隔5分钟查询宝付订单状态

    const LIST_USER_MOBILE_CONTACTS_UPLOAD = 'list_user_mobile_contacts_upload';//每隔五分钟查询时候有通讯记录上传
    const LIST_USER_POCKET_CALCULATION_FAILED = 'list_user_pocket_calculation_failed';//零钱贷寄利息失败
    const LIST_USER_FZD_CALCULATION_LATE_FEE_FAILED = 'list_user_pocket_calculation_failed';//房租贷计算违约金失败



    public static function push($params = [])
    {
        $redis = Yii::$app->redis;
        return $redis->executeCommand('RPUSH', $params);
    }
    
    public static function pop($params = [])
    {
        $redis = Yii::$app->redis;
        return $redis->executeCommand('LPOP', $params);
    }
}