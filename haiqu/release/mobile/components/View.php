<?php
namespace mobile\components;

use Yii;
use yii\helpers\Url;
use common\models\Indiana;

class View extends \yii\web\View
{
    /**
     * 入口文件，不包括域名的目录
     */
    public $baseUrl;

    /**
     * 域名
     */
    public $hostInfo;

    /**
     * $hostInfo + $baseUrl
     */
    public $absBaseUrl;

    /**
     * author myron
     * other
     */
    public $userName;
    public $keywords;
    public $description;
    public $shareLogo;
    public $isSkipID;
    // public $other;

    public function init()
    {
        parent::init();
        $this->baseUrl = Yii::$app->getRequest()->getBaseUrl();
        $this->hostInfo = Yii::$app->getRequest()->getHostInfo();
        $this->absBaseUrl = $this->hostInfo . $this->baseUrl;
        $this->userName = Yii::$app->user->identity['username'];
        // $this->other = '';
    }

    public function isFromApp(){
        return Yii::$app->controller->isFromApp();
    }

    public function isFromWeichat(){
        return Yii::$app->controller->isFromWeichat();
    }

    //ios 新版本页面刷新 带参needRefresh
    public function needRefresh(){
        $script = '';
        if( Yii::$app->getRequest()->getClient()->clientType == 'ios' && version_compare(Yii::$app->getRequest()->getClient()->appVersion, '4.0.0', '>=') && !Yii::$app->request->get('needRefresh') ){
            $script = '
            var url = createUrl(window.location.href,"needRefresh=1");
            jumpTo(url);
            ';
        }
        return $script;
    }
}