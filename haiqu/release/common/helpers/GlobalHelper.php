<?php
namespace common\helpers;
use Yii;

class GlobalHelper
{
	public static function getDomain()
	{
		$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		if (strpos($domain, '668ox.com')) {
			return '668ox.com';
		} else {
			return $domain;
		}
	}

    /**
     * ping db 数据库操作
     * @param string $db
     * @return \yii\db\Connection
     */
    public static function pingDb($db = 'db'){
        $db_handle  = Yii::$app->$db;
        $db_handle->createCommand("select 1")->queryOne();
    }

    /**
     * connect db 重新连接数据库
     * @param string $db
     * @return \yii\db\Connection 返回数据库操作句柄
     */
    public static function connectDb($db = 'db'){
        $db_handle  = Yii::$app->$db;
        if(empty($db_handle)) {
            return false;
        }
        
        try{
            $db_handle->createCommand("select 1")->queryOne();
        }catch (\Exception $e){
            $db_handle->close();
            $db_handle->open();
        }
    }
}