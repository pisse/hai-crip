<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use common\helpers\GlobalHelper;
use common\models\UserLog;

/**
 * Base controller
 *
 * @property \yii\web\Request $request The request component.
 * @property \yii\web\Response $response The response component.
 * @property common\models\Client $client The Client model.
 */
abstract class BaseController extends Controller
{
	// 由于都是api接口方式，所以不启用csrf验证
	public $enableCsrfValidation = false;

	public function init()
	{
		parent::init();

		if ($this->request->get('callback')) { // 参数有callback的话则是jsonp
			$this->getResponse()->format = Response::FORMAT_JSONP;
		} else {
			$this->getResponse()->format = Response::FORMAT_JSON;
		}
	}

	public function beforeAction($action)
	{
		// 用于微信的openid登录
		if ($this->getRequest()->get('contact_id') && Yii::$app->user->getIsGuest()) {
			Yii::$app->user->loginByAccessToken(trim($this->getRequest()->get('contact_id')));
		}

		//日志记录开始
		//UserLog::begin($action);

		return parent::beforeAction($action);
	}

	public function afterAction($action, $result)
	{
		$result = parent::afterAction($action, $result);

		//日志记录结束
		//UserLog::end($result);

		if ($this->request->get('fmt')) {
			// 参数fmt不为空则是iframe post，一般用于跨域post
			$json_str = Json::encode($result);
			$domain = GlobalHelper::getDomain();
			$this->getResponse()->format = Response::FORMAT_HTML;
			echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn" lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta http-equiv="Content-Language" content="utf8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>POST - KD</title>
</head>
<body>
<span id = 'json_data' style=display:none>{$json_str}</span>
<script type="text/javascript">
document.domain = '{$domain}';
<!--
frameElement.callback({$json_str});
//-->
</script>
</body>
</html>
EOT;
			
			Yii::$app->end();
		} else if ($this->getResponse()->format == Response::FORMAT_JSONP) {
			// 特殊处理：如果是验证码，由于已经encode过了，所以需要先decode成原始数据
			if ($action->id == 'captcha') {
				$result = json_decode($result);
			}
			// jsonp返回数据特殊处理
			$callback = Html::encode($this->request->get('callback'));
			$result = [
				'data' => $result,
				'callback' => $callback,
			];
		}
		return $result;
	}

	/**
	 * 获得请求对象
	 */
	public function getRequest()
	{
		return Yii::$app->getRequest();
	}

	/**
	 * 获得返回对象
	 */
	public function getResponse()
	{
		return Yii::$app->getResponse();
	}

	/**
	 * 获得请求客户端信息
	 * 从request中获得，便于调试，有默认值
	 */
	public function getClient()
	{
		return Yii::$app->getRequest()->getClient();
	}

    public function params()
    {
        return array_merge($_GET, $_POST);
    }
    /**
     * 判断是否是app打开
     * @return boolean
     */
    public function isFromApp(){
        return @strstr($_SERVER['HTTP_USER_AGENT'],'HQ') ? true : false;
    }
	/**
	 * 判断是否是美享app打开
	 * @return boolean
	 */
	public function isFromMxApp(){
		return @strpos($_SERVER['HTTP_USER_AGENT'],'MXSH') !== false ? true : false;
	}
    /**
     * 统一设置cookie
     * @param unknown $name
     * @param unknown $val
     * @param unknown $expire
     * @return boolean
     */
    public function setCookie($name,$val,$expire=0){
        $cookieParams = ['httpOnly' => true, 'domain'=>YII_ENV_PROD ? '.668ox.com' : ''];
        if($expire !== null){
            $cookieParams['expire'] = $expire;
        }
        $cookies = new \yii\web\Cookie($cookieParams);
        $cookies->name = $name;
        $cookies->value = $val;
        $this->response->getCookies()->add($cookies);
        return true;
    }
    /**
     * 统一获取cookie
     * @param unknown $name
     * @return mixed
     */
    public function getCookie($name){
        $val = $this->request->getCookies()->getValue($name);
        if($val){
            return $val;
        }
        $val = $this->response->getCookies()->getValue($name);
        return $val;
    }
    
    /**
     * 是否ios在审核
     * @return boolean
     */
    public function isIosInview(){
        $client = Yii::$app->getRequest()->getClient();
        if($this->isFromApp() && $client->clientType == 'ios' && in_array($client->appVersion,Yii::$app->params['iosInViewVersion'])){
            return true;
        }
        return false;
    }
}