<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2014/12/25
 * Time: 14:12
 */

namespace common\exceptions;

use yii\base\UserException;
use yii;

class UserExceptionExt extends UserException
{
    public static function throwCodeExt($code = -1, $appendMsg = "")
    {
        $class = get_called_class();
        $message = "";
        if( property_exists($class, "ERROR_MSG") )
        {
            $ERROR_MSG = $class::$ERROR_MSG;
            $message = !empty($ERROR_MSG[$code]) ? $ERROR_MSG[$code] : "";
        }

        if(!empty($appendMsg))
        {
            $message = $message . $appendMsg;
        }

        $exception = new $class($message, $code);
        $trace = $exception->getTrace();

        $exception->file = basename($trace[0]['file']);
        $exception->line = $trace[0]['line'];
        throw $exception;
    }

    public static function throwMsg( $message = "")
    {
        $class = get_called_class();
        $exception = new $class($message);
        $trace = $exception->getTrace();

        $exception->file = basename($trace[0]['file']);
        $exception->line = $trace[0]['line'];
        throw $exception;
    }

    public static function throwCodeAndMsg($code, $message)
    {
        $class = get_called_class();
        $exception = new $class($message, $code);
        $trace = $exception->getTrace();

        $exception->file = basename($trace[0]['file']);
        $exception->line = $trace[0]['line'];
        throw $exception;
    }

    public static function throwCodeAndMsgExt($message,Array $param=array()){
        $class = get_called_class();
        $code = isset($param['code']) ? $param['code'] : -1;
        $mongo = empty($param['mongo']) ? false : true;
        $content = isset($param['content']) ? $param['content'] : '';

        $exception = new $class($message, $code);

        $trace = $exception->getTrace();

        $exception->file = basename($trace[0]['file']);
        $exception->line = $trace[0]['line'];

        //是否要记录mogdb
        if($mongo){
            Yii::error( [
                'file' => $exception->file,
                'line' => $exception->line,
                'content' => $content,
                'message' => $message,
            ], __CLASS__.'\\'.__FUNCTION__);
        }

        return [
            'code'=>$code,
            'message'=>$message,
            'data'=>[]
        ];
    }
}