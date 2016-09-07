<?php
namespace common\helpers;

class Util
{
    /**
     * 输出对象
     * @param all $rows     需要输出的对象
     * @param bool $type    以print_r还是var_dump来输出
     * @param bool $exit    输出后是否中止
     */
    public static function pr($rows, $type = false, $exit = false)
    {
        echo '<pre>';
        $type ? var_dump($rows) : print_r($rows);
        echo '</pre>';
        $exit && exit();
    }

    /**
     * 将一维数组转为 sql condition 字符串 (['a' => 1, 'b' => 2, 'c => '+1'] To: a=1, b=2, c=c+1)
     * @param array 需要转换的数组对象
     * @return string
     */
    public static function arrayToStr(array $datas = [])
    {
        $str = '';
        if(!empty($datas))
        {
            $s = array('like', 'update', 'id', 'key', 'starting');

            $i = 1;
            $dataCount = count($datas);
            foreach($datas as $key => $data)
            {
                $str .= (in_array($key, $s) ? '`' . $key . '`' : $key) . ($data && in_array($data, array('?+1', '?-1', '?+2', '?-2')) ? '=' . $key . strtr($data, array('?' => NULL)) : '=\'' . mysql_escape_string($data) . '\'') . ($i < $dataCount ? ', ' : NULL);
                $i++;
            }
        }
        return $str;
    }

    public static function exportXml($filename, $title, $data)
    {
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename={$filename}.xls");
        header('Pragma: no-cache');
        header('Expires: 0');

        echo iconv('utf-8', 'GB2312//IGNORE', implode("\t", $title)), "\n";
        foreach ($data as $value) {
            echo iconv('utf-8', 'GB2312//IGNORE', implode("\t", $value)), "\n";
        }

        exit();
    }

    public static function exportCsv($filename, $title, $data)
    {
        $str = '';
        $str .= iconv('utf-8', 'gb2312', implode(",", $title)). "\n";
        foreach ($data as $value) {
            $str .= iconv('utf-8', 'gb2312', implode(",", $value)). "\n";
        }
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $str;
        exit();
    }
    
    /**
     * 用户IP
     */
    public static function getUserIP() {
        $ip = \Yii::$app->getRequest()->getUserIP();

        if(strstr($ip, ",")) {//含有逗号
            $a = explode(",", $ip);
            return trim($a[1]);
        }
        else if (empty($ip) || strstr($ip, ":")) {
            return "192.168.0.1";
        }
        else {
            return $ip;
        }
    }
    
    /**
     * 用户类型
     */
    public static function getClientType() {

        if($_SERVER['SERVER_NAME'] == 'm.668ox.com') {
            return 'wap';
        }
        else {
            if (method_exists(\Yii::$app->getRequest(), 'getClient')) {
                $client  = \Yii::$app->getRequest()->getClient();

                return $client->clientType;
            } else {
                return "pc";
            }
        }
        
    }
    
    
    /**
     * 验证手机
     */
    public static function verifyPhone($phone) {
        
        return preg_match('/^1[0-9]{10}$/', $phone);
    }
    
    public static $_config = [];
    /**
     * 载入配置文件
     * @param $name as (@mobile/test,@frontent/test,test)
     * 例子:Util::loadConfig('@frontend/test'),Util::loadConfig('test')
     * 
     */
    public static function loadConfig($name) {
        if (!isset(self::$_config[$name])) {
            if(!strncmp($name, '@', 1)){//use an alias
                $pos = strpos($name, '/');
                $root = \Yii::getAlias(substr($name,0, $pos)).'/config';
                $configFilePath = $root.substr($name, $pos);
            }else if(strpos($name, '/') || strpos($name, '\\')){
                $configFilePath = realpath($name);
            }else{
                $configFilePath = \Yii::$app->getBasePath() . DIRECTORY_SEPARATOR . 'config/'.$name;
            }
            $configFilePath = $configFilePath.'.php';
            if (!file_exists($configFilePath)) {
                throw new \yii\base\Exception('load config data '.$name.' failed');
            }
            self::$_config[$name] = require($configFilePath);
        }
        return self::$_config[$name];
    }
}