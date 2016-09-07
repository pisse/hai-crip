<?php
/**
 * Created by PhpStorm.
 * User: haoyu
 * Date: 2014/10/27
 * Time: 14:27
 */
namespace common\api;
use yii;

class HttpRequest
{
    const HTTP_Status_Code_OK = 200;
    const HTTP_Status_200_Code_OK = 200;
    const HTTP_Status_302_Move_Temporarily = 302;

    const POST_DATA_TYPE_ORIGIN = 0; // 原始数据
    const POST_DATA_TYPE_FIELD = 1; // key1=value1&key2=value2&key3=value3形式
    const POST_DATA_TYPE_JSON = 2; // json赋值

    const PARA_ERROR_URL = 1; //


    private $ERROR_DESC = array(
        self::PARA_ERROR_URL => "URL格式错误",
    );

    public $getFields;// get 参数列表

    public $postFields; // post 参数列表

    public $method = "GET"; // 默认Get

    public $url = "";// 发送的URL

    public $header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");

    // post的数据结构
    /*
     *  默认为 1。
     *  0表示: 采用 array 的方式
     *  1表示: 采用 key1=value1&key2=value2&key3=value3的方式，且进行了urlencode
     *  2表示: 采用 json 的格式
     */
    public $postDataFormat = self::POST_DATA_TYPE_FIELD;

    public $code = "";

    /*
     * send 发送 Http 请求
     * 返回值 code是http的返回值，resp是业务方返回的值
     * */
    public function send()
    {
        //初始化curl
        $ch = curl_init();

        if (empty($this->url))
        {
            return $this->getErrInfo(self::PARA_ERROR_URL);
        }

        if ( empty($this->getFields))
        {
            // get 参数列表
            if( is_array($this->getFields))
            {
                $getFields = http_build_query($this->getFields);
            }
            else
            {
                $getFields = $this->getFields;
            }
            curl_setopt ($ch, CURLOPT_URL, $this->url.$getFields);
        }
        else
        {
            curl_setopt ($ch, CURLOPT_URL, $this->url);
        }

        // 默认用Get
        if ( strtoupper($this->method) == "POST")
        {
            // post提交方式
            curl_setopt ($ch, CURLOPT_POST, true);

            // post 参数列表
            $postFields = $this->postFields;
            if ( $this->postDataFormat == self::POST_DATA_TYPE_FIELD)
            {
                $postFields = http_build_query($this->postFields);
            }
            else if( $this->postDataFormat == self::POST_DATA_TYPE_JSON)
            {
                $postFields = json_encode($this->postFields);
            }
            Yii::info("post body = ".var_export($postFields,true));

            curl_setopt ($ch, CURLOPT_POSTFIELDS, $postFields);
        }

        
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $this->header);


        // CURLOPT_RETURNTRANSFER = true 结果返回到变量中，而不是输出到屏幕
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

        //设置代理服务器, fiddle 抓包用的到
        // curl_setopt ($ch, CURLOPT_PROXY, "127.0.0.1:8888");

        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $httpResp = curl_exec($ch);

        Yii::info("httpResp=".var_export($httpResp,true));

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_getinfo = curl_getinfo($ch);
        $this->code = $httpCode;

        curl_close($ch);
        return array(
            'code' => $this->code,
            'resp' => $httpResp,
            'curl_getinfo' => $curl_getinfo
        );
    }

    public function getRespCode(){
        return $this->code;
    }


    public function isHttpCodeOk()
    {
        return $this->getRespCode() == self::HTTP_Status_Code_OK ? true : false;
    }

    private function getErrInfo($code){
        return array(
            'code' => $code,
            'resp' => $this->ERROR_DESC[$code],
        );
    }
}