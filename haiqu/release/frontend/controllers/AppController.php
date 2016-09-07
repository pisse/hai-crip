<?php
namespace frontend\controllers;

use common\exceptions\CodeException;
use common\helpers\CurlHelper;
use common\models\UserCredit;
use common\models\UserRentCredit;
use common\models\Version;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\Setting;
use common\services\PayService;
use common\api\HttpRequest;
use common\exceptions\UserExceptionExt;
/**
 * App controller
 */
class AppController extends BaseController
{
    /**
     * 下发配置
     * @name 下发配置 [getConfig] 
     * @param string $configVersion 配置版本号
     * @uses 用于客户端获取url配置 
     */
    public function actionConfig($configVersion)
    {
        // 此处版本号时间戳尽量取当前时间点
        $ver = '';
        $setting = Setting::findByKey('app_time_stamp'); //后台配置下发时间戳(后台可更改)

        if(isset($setting) && $setting->svalue){
            $ver = $setting->svalue;
        }
        // 取大值为配置的时间戳

        $confVer = max(strtotime('2016-06-06 17:50:00'), $ver);

        // 如果是ios的3.10.0版本强制给最新配置
        if ($this->client->clientType == 'ios' && version_compare($this->client->appVersion, '3.10.0') == 0) {
            $confVer = time();
        }

        if ($configVersion == $confVer) {
            return [
                'code' => -1,
                'message' => '配置无更新',
                'data'=>['item'=>[]],
            ];
        }
        
        // 约定：api域名且是json返回的情况下考虑使用https,即拼接地址的时候采用$baseUrlHttps
        $baseUrl = $this->getRequest()->getHostInfo() . $this->getRequest()->getBaseUrl();

        if (YII_ENV_PROD && version_compare($this->client->appVersion, '4.1.0') >= 0 && $this->getRequest()->getHostInfo() == 'http://api.668ox.com') {
            $baseUrlHttps = 'https://api.668ox.com';
        } else {
            $baseUrlHttps = $baseUrl;
        }



        $config = [
            'name'				=> '嗨去',
            'configVersion'		=> $confVer,
            'iosVersion'		=> Yii::$app->params['appConfig']['iosVersion'],
            'androidVersion'	=> Yii::$app->params['appConfig']['androidVersion'],

            'dataUrl'			=> [
                'userRegGetCode' => "{$baseUrlHttps}/user/reg-get-code",
                'userRegister' => "{$baseUrlHttps}/user/register",
                'userLogin' => "{$baseUrlHttps}/user/login",
                'userQuickLogin' => "{$baseUrlHttps}/user/quick-login",
                'userLogout' => "{$baseUrlHttps}/user/logout",
                'userChangePwd' => "{$baseUrlHttps}/user/change-pwd",

            ],
        ];

        return [
            'code'=>0,
            'message'=>'success',
            'data'=>['item'=>$config],
        ];
    }










}

