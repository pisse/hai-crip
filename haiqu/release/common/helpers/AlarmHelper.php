<?php

namespace common\helpers;

use Yii;
use yii\base;

class AlarmHelper {

    const ALARM_SERVER_IP = '10.168.54.252';

    const ALARM_SERVER_PORT = 11000;
    
    private static $_instance = null;

    private static function getInstance() {
        if(empty(self::$_instance)) {
            self::$_instance = new AlarmHelper();
        }
        return self::$_instance;
    }

    public static function send($markerId, $content) {
        $msg = json_encode([
            'markerId' => $markerId,
            'content' => $content
        ]);
        $len = strlen($msg);
        $ins = self::getInstance();
        $connection = $ins->getConnection();
        if(!empty($connection)) {
            $ret = socket_sendto($connection, $msg, $len, 0, self::ALARM_SERVER_IP, self::ALARM_SERVER_PORT);
            if(empty($ret)) {
                $code = socket_last_error($connection);
                $msg = socket_strerror($code);
                Yii::error("Failed to send data, error {$code} : {$msg}.");
            }
        }

    }

    private $_connection = null;

    private function __construct() {
        
    }

    public function __destruct() {
        if(!empty($this->_connection)) {
            socket_close($this->_connection);
        }
    }

    private function getConnection() {
        if(empty($this->_connection)) {
            $this->_connection = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            if(empty($this->_connection)) {
                $code = socket_last_error();
                $msg = socket_strerror($code);
                Yii::error("Failed to create socket, error {$code} : {$msg}.");
            }
        }

        return $this->_connection;
    }
}