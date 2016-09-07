<?php

namespace frontend\controllers;

use common\models\LoanPersonInfo;
use Yii;
use common\helpers\TimeHelper;
use common\models\BankConfig;
use common\models\LoanPerson;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\db\Query;
use common\services\UserService;
use common\models\UserCaptcha;
use common\models\UserLoginLog;
use common\helpers\StringHelper;
use yii\web\Response;
use yii\captcha\CaptchaValidator;
use common\models\UserPhoneChange;
use common\models\UserRedis;
use yii\base\Object;
use common\helpers\Util;
use common\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Company;
use common\helpers\ToolsUtil;
use common\models\UserDetail;
use common\helpers\MailHelper;
use common\models\UserFeedback;
use common\exceptions\UserExceptionExt;
/**
 * User controller
 */
class SettingController extends BaseController
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
                'except' => ['reg-get-code', 'reg-get-audio-code', 'register', 'login', 'logout',
                    'reset-pwd-code', 'verify-reset-password', 'reset-password', 'state', 'captcha','yirute-tid'],
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
     * 获取设置中相关信息
     * @name    获取设置中相关信息 [settingGetInfo]
     * @uses    获取设置中相关信息
     * @author  honglifeng
     */
    public function actionGetInfo(){
        $curUser = Yii::$app->user->identity;
        $user_id = $curUser->getId();

        $data = array();

        $data['relation_tel']="021-80260891";

        return [
            'code'=>0,
            'message'=>'success',
            'data'=>[
                'item'=>$data,
            ],
        ];
    }


    /**
     * 反馈意见
     * @name    反馈意见 [settingFeedback]
     * @uses    反馈意见
     * @method  post
     * @param   text $content 反馈意见
     * @author  honglifeng
     */

    public function actionFeedback(){

        $curUser = Yii::$app->user->identity;
        if(empty($curUser)){
            return UserExceptionExt::throwCodeAndMsgExt(CodeException::$code[CodeException::LOGIN_DISABLED],['code'=>CodeException::LOGIN_DISABLED]);
        }

        $content = trim($this->request->post('content', ''));
        $content = stripslashes($content);

        if(empty($content)){
            return UserExceptionExt::throwCodeAndMsgExt('请填写反馈意见');
        }

        $user_feedback = new UserFeedback();
        $user_feedback->user_id = $curUser->getId();
        $user_feedback->content = $content;
        $user_feedback->created_at = time();
        $user_feedback->updated_at = time();

        if($user_feedback->save()){
            return [
                'code'=>0,
                'message'=>'反馈成功',
                'data'=>['item'=>[]],
            ];
        }else{
            return UserExceptionExt::throwCodeAndMsgExt('反馈失败,请稍后再试');
        }

    }

}