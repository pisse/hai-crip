<?php
/**
 * 用户操作日志
 */

namespace common\models;

use common\helpers\Util;

class FinancialLog extends \yii\mongodb\ActiveRecord {

    private static $_log            = [];     //日志内容
    private static $_log_user       = [];     //用户信息
    private static $_log_type       = [];     //业务类型信息
    private static $_log_detail     = [];     //日志详细内容
    private static $_log_exception  = [];     //日志错误内容


    private static $_method_arr = [];     //方法详细内容

    private static $_log_begin  = false;//日志记录开始

    //日志业务类型配置
    const ACTION_YEEPAY_CP_NOTIFY = 1;
    const ACTION_LIANDONG_CP_NOTIFY = 2;


    public  static $business_action = [
        self::ACTION_YEEPAY_CP_NOTIFY => 'actionYeepayCpNotify',
        self::ACTION_LIANDONG_CP_NOTIFY => 'actionLianDongCpNotify',

    ];

    public static $business = [
        'actionYeepayCpNotify' => [
            'title' => "A扣款回调",
            'type'  => self::ACTION_YEEPAY_CP_NOTIFY,
        ],
        'actionLianDongCpNotify' => [
            'title' => "B扣款回调",
            'type'  => self::ACTION_LIANDONG_CP_NOTIFY,
        ],
    ];

    //表名
    public static function collectionName()
    {
        return 'financial_log';
    }

    /**
     * 日志记录开始
     * @param mixed $type   业务类型
     */
    public static function begin($type) {

        register_shutdown_function(function(){
            self::end();
        });
        $type_result = self::setBusinessType($type);
        if ($type_result == false) {
            return false;
        }
        self::$_method_arr = $type_result;//设置日志业务类型
        self::$_log_begin = true;   //日志记录开始标记

        self::$_log['begin_time'] = time(); //日志记录开始时间
        self::$_log['client'] = Util::getClientType(); //客户端类型
        self::$_log['ip'] = Util::getUserIP(); //IP地址

        self::setType(self::$_method_arr);//日志类型

        //日志详细
        if(array_key_exists("pay_password", $_REQUEST)) {
            unset($_REQUEST['pay_password']);  //删除支付密码
        }
        if(array_key_exists("password", $_REQUEST)) {
            unset($_REQUEST['password']);  //删除密码
        }
        self::addLogDetail(self::$_method_arr['title'] . '-开始', $_REQUEST);
    }

    /**
     * 日志记录结束
     */
    public static function end($result = '') {
        if(is_object($result) || !self::$_log_begin) {
            return false;
        }
        if (empty(self::$_log_user)) {  //设置用户信息
            self::setUser(\Yii::$app->user->identity);
        }

        self::addLogDetail(self::$_method_arr['title'] . '-结束', $result);

        self::$_log['end_time'] = time(); //结束时间
        self::$_log['user']    = self::$_log_user;
        self::$_log['business'] = self::$_log_type;
        self::$_log['details'] = self::$_log_detail;

        try {
            $collection = self::getCollection();
            $collection->insert(self::$_log);
        }
        catch (\Exception $e) {//Mongodb 异常

        }
        self::$_log_begin = false;
        self::$_log = [];
        self::$_log_type = [];
        self::$_log_detail = [];
        self::$_log_exception = [];
    }


    /**
     * 设置日志详细内容
     * @param $title
     * @param string $data
     * @return bool
     */
    public static function addLogDetail($title = '', $data = '') {
        if (empty($title)) {
            return false;
        }
        $log_detail = [];
        $log_detail['time'] = time();
        $log_detail['title'] = $title;
        $log_detail['data'] = $data;
        array_push(self::$_log_detail, $log_detail);
    }

    /**
     * 异常日志
     * @param Exception $exception
     */
    public static function addExceptionLog($exception) {
        if(!self::$_log_begin) {
            return false;
        }
        $log_data = [];
        $log_data['err_code'] = $exception->getCode();
        $log_data['err_msg']  = $exception->getMessage();
        $log_data['file']     = $exception->getFile();
        $log_data['line']     = $exception->getLine();
        self::$_log_exception = $log_data;
        self::addLogDetail(self::$_log_type['title'] . '异常', $log_data);
        self::$_log['exception'] = self::$_log_exception;
        self::end();
    }

    /**
     * 设置业务父类型
     * @param $data
     */
    public static function setType($data = '') {
        if (empty($data)) {
            return false;
        }
        if (is_array($data)) {
            self::$_log_type['title'] = $data['title'];
            self::$_log_type['type']  = $data['type'];
            self::$_log_type['type_son'] = isset($data['type_son']) ? $data['type_son'] : 0;
        }
        return true;
    }

    /**
     * 设置业务子类型
     * @param $data
     * @return bool
     */
    public static function setTypeSon($data = '') {
        if (empty($data)) {
            return false;
        }
        self::$_log_type['type_son'] = isset($data['type_son']) ? $data['type_son'] : 0;
        return true;
    }

    /**
     * 设置用户信息(数组或者对象)
     * @param object $user
     */
    public static function setUser($user) {
        if (empty($user)) {
            return false;
        }
        if (is_array($user)) {
            self::$_log_user['uid'] = intval($user['id']);
            self::$_log_user['phone'] = isset($user['phone']) ? strval($user['phone']) : '';
        } else if (is_object($user)) {
            self::$_log_user['uid'] = intval($user->id);
            self::$_log_user['phone'] = isset($user->phone) ? strval($user->phone) : '';
        }
        return true;
    }

    public static function setBusinessType($type) {
        $method = "";
        $type_arr = self::$business;
        if (is_int($type) && array_key_exists($type, self::$business_action)) {
            $method = self::$business_action[$type];
        } else {
            if (!is_object($type) || !property_exists($type, 'actionMethod')) {
                return false;
            }
            $method = $type->actionMethod;
        }
        if (!empty($method) && isset($type_arr[$method])) {
            return $type_arr[$method];
        }
        return false;
    }


    public static function getDb() {

        return \Yii::$app->get('mongodb_log');
    }

}
