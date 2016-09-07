<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/4/28
 * Time: 17:01
 */
namespace common\helpers;


class ToolsUtil{

    public static $code = 0;
    public static $message = "";


    /**
     * 初始化信息
     */
    private static function init(){
        self::$code = 0;
        self::$message  = '';
    }


    /**
     * @param $text
     * @return array
     * 判断只能为中文、英文、数字、下划线，主要是用来判断中英文的
     */
    public static function checkText($text){

        $pattern = '/^(?!_|\s\')[A-Za-z0-9_\x80-\xff\s\']+$/';

        if(!empty($text)&& preg_match($pattern, $text)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证手机号是否合法
     * @param $mobile
     * @return bool
     */

    public static function checkMobile($mobile){
        $pattern = '/^1[0-9]{10}$/';
        if (preg_match($pattern,$mobile)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证数字是否合法
     * @param $num
     * @return bool
     */
    public static function checkNum($num){

        if(preg_match('/^\d*$/',$num)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证邮箱是否合法
     * @param $email
     * @return bool
     */
    public static function checkEmail($email){

        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if ( preg_match( $pattern, $email ) ){

            return true;
        }
        else{

            return false;
        }
    }

    /**
     * 验证身份证是否合法
     * @param $id_number
     * @return bool
     */
    public static function checkIdNumber($id_number){

        $pattern = '/^\d{17}[\d\w]$|^\d{15}$/';
        if(preg_match($pattern, $id_number)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证中文名是否合法
     * @param $name
     * @return bool
     */
    public static function checkChineseName($name){

        $pattern = '/^[\x80-\xff]{4,30}$/';
        if( preg_match($pattern, $name)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 生成单号
     * @param string $prefix 号前缀
     */
    public static function createOrderId($pre){
        $prefix = rand(0, 9);
        $id =  uniqid($prefix);
        $id = strtoupper($id);
        $time = date("YmdHis",time());
        $pre = $pre.$time;
        $id = substr($id,0,20-strlen($pre));
        $id = $pre.$id;

        return $id;
    }


}