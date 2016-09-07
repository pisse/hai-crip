<?php

namespace common\helpers;

use common\models\BankConfig;

class StringHelper extends \yii\helpers\StringHelper
{
	/**
	 * 模糊手机号
	 * 比如：13917883434 变成 139****3434
	 */
	public static function blurPhone($phone)
	{
		return substr($phone, 0, 3) . '****' . substr($phone, 7);
	}

    /**
     * 模糊真名
     * 比如：林佳神 变成 *佳神
     */
    public static function blurName($name)
    {
        return '*' . mb_substr($name, 1, 8, 'UTF-8');
    }

    /**
     * 模糊银行卡
     * 比如：6224 8851 1234 4568 变成 6224 **** 4568
     */
    public static function blurCardNo($card_no)
    {
        $start_pos = strlen($card_no) - 4;
        return substr($card_no, 0, 4) . ' **** ' . substr($card_no, $start_pos);
    }

    /**
     * 模糊身份证
     * 比如：302121 21212112 112x 变成 3021 ********** 112x
     */
    public static function blurIdCard($card_no)
    {
        $start_pos = strlen($card_no) - 8;
        return substr($card_no, 0, 4) . preg_replace("/\d/", '*', substr($card_no, 5, $start_pos)) . substr($card_no, -4);
    }

    /**
     * 安全的将“元”转化成“分”
     * 比如：10.01 变成 1001
     */
    public static function safeConvertCentToInt($num)
    {
        return intval(bcmul(floatval($num) , 100));
    }

    /**
     * 安全的将“分”转化成“元”
     * 比如：1001 变成 10.01
     */
    public static function safeConvertIntToCent($num){
        return sprintf('%.2f',$num / 100);
    }

    const ONE_MONTH = 30;
    const YEAR_DAYS = 365;
    /**
     * 输入的月份数变成天数
     * @param $numberM 月份数
     */
    public static function monthToDays($numberM){
        if ($numberM < 12 ){
            return intval($numberM * self::ONE_MONTH);
        }
        $years = intval($numberM / 12 ) ;
        $months = intval($numberM % 12) ;
        return intval(self::YEAR_DAYS * $years + self::ONE_MONTH * $months);
    }

    /**
     * 生成唯一ID
     * @return string
     */
    public static function generateUniqid()
    {
    	$prefix = rand(0, 9);
    	return uniqid($prefix);
    }

    /*********************************************************************
    函数名称:encrypt
    函数作用:加密解密字符串
    使用方法:
    加密     :encrypt('str','E','nowamagic');
    解密     :encrypt('被加密过的字符串','D','nowamagic');
    参数说明:
    $string   :需要加密解密的字符串
    $operation:判断是加密还是解密:E:加密   D:解密
    $key      :加密的钥匙(密匙);
     *********************************************************************/
    static public function encrypt($string,$operation,$key='nowamagic')
    {
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D')
        {
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
            {
                return substr($result,8);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return str_replace('=','',base64_encode($result));
        }
    }

    // 删除银行卡中的空格
    public static function trimBankCard($bank_card)
    {
        $bank_card = str_replace(" ",'',$bank_card);
        if(preg_match('/^[0-9]{10,24}$/',$bank_card))
        {
            return $bank_card;
        }
        return false;
    }

    //验证数字
    public static function verifyNumber($str) {
        $str = str_replace(" ", '', $str);
        if (preg_match('/^[0-9]*$/', $str)) {
            return $str;
        }
        return false;
    }

    /**
     * 输入的月份数变成天数
     * @param array $bank  
     */
    public static function getBankAmountRestrict($bank)
    {
//         $bank_name = $bank['name'];
        $sml       = $bank['sml'];
        $dml       = $bank['dml'];
        $dtl       = $bank['dtl'];
        $platform  = $bank['third_platform'];
        $limit_desc = $bank['pay_limit_desc'];
        
        $sml_desc = self::getAmountDesc($sml);
        $dml_desc = self::getAmountDesc($dml);
        
        if(!empty($limit_desc)) {
            $limit_desc = "，" . $limit_desc;
        }
        
        return "最高单笔{$sml_desc}，单日{$dml_desc}{$limit_desc}";
    }

    public static function getAmountDesc($amount)
    {
        $one_thousand = 100000;
        $ten_thousand = 10 * $one_thousand;
        // 大于1万
        if( $amount >= $ten_thousand )
        {
            $amount_desc = intval($amount / $ten_thousand) . "万";
        }
        else if ( $amount >= $one_thousand )
        {
            $amount_desc = intval($amount / $one_thousand) . "千";
        }
        else
        {
            $amount_desc = intval($amount / 100). "元";
        }
        return $amount_desc;
    }
    
    public static function getNumFromStr($str)
    {
        preg_match_all('/\d+/', $str, $arr);
        $arr = $arr[0];
        if (empty($arr)) {
            $ret = "无限额";
        } else {
            $num = $arr[0];
            $s   = strpos($str, $num);
            $ret = $num . "万";
        }
        return $ret;
    }

    public static function getAmountToTenThousand($amount)
    {
        $one_thousand = 100000;
        $ten_thousand = 10 * $one_thousand;

        $amount_desc = sprintf("%.2f",floatval($amount / $ten_thousand));

        return $amount_desc;
    }

    //验证身份证号码是否合法(兼容15位和17位)
    public static function isIdCard($idcard){
        $iSum = 0;
        $idCardLength = strlen($idcard);
        //长度验证
        if(!preg_match('/^\d{17}(\d|x)$/i',$idcard) and !preg_match('/^\d{15}$/i',$idcard))
        {
            return false;
        }
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        // 15位身份证验证生日，转换为18位
        if ($idCardLength == 15)
        {
            if (strlen($idcard) != 15){
                return false;
            }else{
                //若身份证顺序码是996 997 998 999，说明是为百岁老人准备的特殊码
                if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
                    $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
                }else{
                    $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
                }
            }
            $checksum = 0;
            for ($i = 0; $i < strlen($idcard); $i++){
                $checksum += substr($idcard, $i, 1) * $factor[$i];
            }
            $mod = $checksum % 11;
            $verify_number = $verify_number_list[$mod];
            $idcard = $idcard .$verify_number;
        }
        if (strlen($idcard) != 18){ return false; }
        $idcard_base = substr($idcard, 0, 17);
        if (strlen($idcard_base) != 17){ return false;}
        $checksum = 0;
        for ($i = 0; $i < strlen($idcard_base); $i++){
            $checksum += substr($idcard_base, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        $verify_number = $verify_number_list[$mod];
        if ($verify_number != strtoupper(substr($idcard, 17, 1))){
            return false;
        }else{
            return true;
        }
    }
}