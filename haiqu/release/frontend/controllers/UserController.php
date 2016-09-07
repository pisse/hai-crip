<?php

namespace frontend\controllers;

use common\helpers\ToolsUtil;
use common\models\User;
use console\models\NetUtil;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\web\Response;
use yii\captcha\CaptchaValidator;
use yii\base\Object;
use yii\helpers\Url;
use common\services\UserService;
/**
 * User controller
 */
class UserController extends BaseController
{
    protected $userService;

    /**
     * 构造函数中注入UserService的实例到自己的成员变量中
     * 也可以通过Yii::$container->get('userService')的方式获得
     */
    public function __construct($id, $module, UserService $userService, $config = [])
    {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 除了下面的action其他都需要登录
                'except' => ['register', 'login', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'testLimit' => 1,
                'height' => 35,
                'width' => 80,
                'padding' => 0,
                'minLength' => 4,
                'maxLength' => 4,
                'foreColor' => 0x444444,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * 注册步骤二：验证手机号获和验证码，并设置登录密码
     *
     * @name 注册 [userRegister]
     * @method  post
     * @param string $phone 手机号
     * @param string $password 密码
     * @param integer $source 来源 0：默认
     * @author  honglifeng
     */
    public function actionRegister(){
        $phone = trim($this->request->post('phone'));
        $password = trim($this->request->post('password'));
        $source = intval($this->request->post('source'),0);
        if(empty($phone)){
            return [
                'code'=>-1,
                'message'=>'手机号不能为空',
            ];
        }
        if(!ToolsUtil::checkMobile($phone)){
            return [
                'code'=>-1,
                'message'=>'手机号不合法',
            ];
        }
        if(empty($password)){
            return [
                'code'=>-1,
                'message'=>'密码不能为空',
            ];
        }

        $user = User::findByPhone($phone);
        if($user){
            return [
                'code'=>-1,
                'message'=>'该手机号已经被注册',
            ];
        }

        $user = $this->userService->registerByPhone($phone, $password,$source);
        if(false == $user){
            return [
                'code'=>-1,
                'message'=>'系统繁忙,请稍后再试'
            ];
        }
        $data = [
            'uid' => $user->id,
            'username' => $user->username,
            'realname' => $user->realname,
            'user_sign'=> $user->auth_key,
            'sessionid' => Yii::$app->session->getId(),
        ];

        return [
            'code' => 0,
            'message'=>'注册成功',
            'data'=>['item'=>$data],
        ];


    }



}