<?php
namespace mobile\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use backend\controllers\BaseController;
use backend\models\LoginForm;
use backend\models\AdminUserRole;
use backend\models\AdminUser;
use common\models\UserCaptcha;
use common\services\UserService;

/**
 * Main controller
 */
class MainController extends BaseController
{
	public $verifyPermission = false;
	
	/**
	 * @inheritdoc
	 */
	public function behaviors(){
		return [
			'access' => [
				'class' => AccessControl::className(),
				'except' => ['index'],
				'rules' => [
					[
						'actions' => ['login', 'error', 'captcha', 'phone-captcha'],
						'allow' => true,
					],
					[
						'actions' => ['logout', 'home'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions(){
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'testLimit' => 1,
				'height' => 35,
				'width' => 80,
				'padding' => 0,
				'minLength' => 4,
				'maxLength' => 4,
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}
	
	/**
	 * 登录
	 */
	public function actionLogin(){
		// 已经登录则直接跳首页
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$this->layout = true;
		$model = new LoginForm();


		if ($model->load($this->request->post()) && $model->login()) {
			// 把权限信息存到session中
			if ($model->getUser()->role && $roleModel = AdminUserRole::find()->andWhere("name in('".implode("','",explode(',',$model->getUser()->role))."')")->all()) {
				$arr = array();
				foreach ($roleModel as $val) {
					if($val->permissions)
					$arr = array_unique(array_merge($arr,json_decode($val->permissions)));
				}
				Yii::$app->getSession()->set('permissions', json_encode($arr));
			}
			//UserCaptcha::deleteAll(['phone' => $model->getUser()->phone, 'type' => UserCaptcha::TYPE_ADMIN_LOGIN]);
			$this->goHome();
		}
	
		return $this->render('login', [
			'model' => $model,
		]);
	}
	
	/**
	 * 获取登录验证码
	 */
	public function actionPhoneCaptcha(){
		$this->getResponse()->format = Response::FORMAT_JSON;
		
		$username = trim($this->request->get('username'));
		if (!$username) {
			return ['code' => -1, 'message' => '输入有误'];
		}

		$user = AdminUser::findOne(['username' => $username]);

		$userService = Yii::$container->get('userService');
		if (!$user || !$user->phone) {
			return ['code' => -1, 'message' => '输入有误'];

		} else if ($userService->generateAndSendCaptcha(trim($user->phone), UserCaptcha::TYPE_ADMIN_LOGIN)) {
			return ['code' => 0];
		} else {
			return ['code' => -1, 'message' => '发送验证码失败'];
		}
	}
	
	/**
	 * 外层框架首页
	 */
	public function actionIndex(){
		return $this->render('index');
	}
	
	/**
	 * iframe里面首页
	 */
	public function actionHome(){
		return $this->render('home');
	}
	
	/**
	 * 退出
	 */
	public function actionLogout(){
		Yii::$app->user->logout();
		return $this->redirect(['login']);
	}
}