<?php

namespace common\helpers;

use Yii;

class MessageHelper
{
    public static function sendSMS($phone, $message, $smsServiceUse = 'smsService')
    {
        if ($smsServiceUse == 'smsService') {
            $msg = urlencode($message);
            $url = Yii::$app->params['smsService']['url'];
            $uid = Yii::$app->params['smsService']['uid'];
            $auth = md5(Yii::$app->params['smsService']['code'] . Yii::$app->params['smsService']['password']);

            $result = file_get_contents("{$url}?uid={$uid}&auth={$auth}&mobile={$phone}&msg={$msg}&expid=0&encode=utf-8");
            // 返回值要是0这种格式才成功，后面是短信id
            if ($result && strpos($result, ',') !== false) {
                list($resCode, $resMsg) = explode(",", $result);
                if ($resCode == '0') {
                    return true;
                }
            } else {
                Yii::error("发送短信失败，result:{$result} mobile:{$phone} msg:{$msg}");
                return false;
            }
        }else if('smsService1' == $smsServiceUse){
            $msg = urlencode($message);
            $url = Yii::$app->params['smsService1']['url'];
            $uid = Yii::$app->params['smsService1']['uid'];
            $auth = md5(Yii::$app->params['smsService1']['code'] . Yii::$app->params['smsService1']['password']);

            $result = file_get_contents("{$url}?uid={$uid}&auth={$auth}&mobile={$phone}&msg={$msg}&expid=0&encode=utf-8");
            // 返回值要是0这种格式才成功，后面是短信id
            if ($result && strpos($result, ',') !== false) {
                list($resCode, $resMsg) = explode(",", $result);
                if ($resCode == '0') {
                    return true;
                }
            }else{
                Yii::error("发送短信失败，result:{$result} mobile:{$phone} msg:{$msg}");
                return false;
            }

        }

    }

}