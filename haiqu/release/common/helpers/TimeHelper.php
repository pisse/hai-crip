<?php
/**
 * Created by PhpStorm.
 * User: haoyu
 * Date: 2014/11/8
 * Time: 18:25
 */

namespace common\helpers;
use Yii;


class TimeHelper
{
    const DAY = 86400;

    const LIMIT_DAYS = 7;
    // DateA 是否比 DateB 大于 30天
    public static function getLimitDay(){
        return self::LIMIT_DAYS * self::DAY;
    }

    public static function isLT30Days($timeA, $timeB)
    {
        $timeA = self::zeroClockTimeOfDay($timeA);
        $timeB = self::zeroClockTimeOfDay($timeB);
        if ( $timeA - $timeB >= self::getLimitDay())
        {
            return true;
        }
        return false;
    }

    // 转换成当天0点的Linux时间戳
    public static function zeroClockTimeOfDay($time)
    {
        // 如果是linux时间戳
        if (is_numeric($time))
        {
            $date = date("Y-m-d",$time);
            return strtotime($date);
        }
        // 如果是日期函数
        else if (is_string($time)){
            $time = strtotime($time);
            return self::zeroClockTimeOfDay($time);
        }
        return false;
    }

    // 转换成当天24点的Linux时间戳
    public static function twentyFourTimeOfDay($time)
    {
        // 如果是linux时间戳
        if (is_numeric($time))
        {
            $date = date("Y-m-d",$time + self::DAY);
            return strtotime($date);
        }
        // 如果是日期函数
        else if (is_string($time)){
            $time = strtotime($time);
            return self::twentyFourTimeOfDay($time);
        }
        return false;
    }

    /*
    public static function Now($delay = ""){
        return strtotime($delay, time());
    }
    */

    public static function Now(){
        return time();
    }

    public static function Today(){
        return date("Y-m-d",self::Now());
    }

    // 获得时间的前一天
    public static function Yesterday($time = '')
    {
        if(empty($time))
        {
            $time = strtotime(self::Today());
        }
        else
        {
            if(is_string($time))
            {
                $time = strtotime($time);
            }
        }
        return date("Y-m-d", strtotime("-1 day", $time));
    }

    // 获得时间的后一天
    public static function Tomorrow($time = '')
    {
        if(empty($time))
        {
            $time = strtotime(self::Today());
        }
        else
        {
            if(is_string($time))
            {
                $time = strtotime($time);
            }
        }
        return date("Y-m-d", strtotime("+1 day", $time));
    }

    // 获得两个日期相差的天数
    public static function DiffDays($dateA, $dateB){
        return intval( ( strtotime($dateA) - strtotime($dateB) ) / self::DAY );
    }

    // 拆分投资期限
    // $start_time 起息日
    // $repay_time 还款日
    public static function splitInvestDays($start_time, $repay_time)
    {
        $today = strtotime(date("Y-m-d"));
        // 结息日 = 还款日 - 2
        $end_time = $repay_time - 2 * self::DAY;
        $total_days = ($end_time - $start_time) / self::DAY + 1;
        $last_days = ($today - $start_time) / self::DAY;
        $rest_days = ($end_time - $today) / self::DAY + 1;
        return [
            "total_days" => $total_days,
            "last_days" => $last_days,
            "rest_days" => $rest_days,
        ];
    }

    /**
     * 判断不能重复提交(5秒内)
     * $time_limit 时间限制秒数
     * $type 类型
     * @return bool
     */
    public static  function identifyTime($time_limit, $type){
        $session = Yii::$app->session;
        $user_id = Yii::$app->user->identity->getId();
        $sessionKey = $user_id.$type;
        if(isset($session[$sessionKey]))
        {
            $first_submit_time = $session[$sessionKey];
            $current_time = time();
            if($current_time - $first_submit_time < $time_limit)
            {
                $session[$sessionKey] = $current_time;
                return false;
            }
            else
            {
                unset($session[$sessionKey]);//超过限制时间，释放session";
            }
        }
        //第一次点击确认按钮时执行
        if(!isset($session[$sessionKey]))
        {
            $session[$sessionKey] = time();
        }
        return true;
    }
    /**
     * 返回获取毫秒时间数组:[0]秒，[1]毫秒
     */
    public static  function getMillisecond(){
        list($t1, $t2) = explode(' ', microtime());
        $time =  sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
        $ret = explode('.', $time / 1000);
        $ret[1] = sprintf('%03s',$ret[1]);
        return $ret;
    }
}