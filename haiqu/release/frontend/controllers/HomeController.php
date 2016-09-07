<?php

namespace frontend\controllers;

use common\helpers\ToolsUtil;
use common\models\HomeActivity;
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
/**
 * User controller
 */
class HomeController extends BaseController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 除了下面的action其他都需要登录
                'except' => ['get-activity-list', 'get-home-all-activity-list', 'logout'],
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
     * 获取首页三个列表
     *
     * @name 获取首页三个列表 [homeGetHomeAllActivityList]
     * @method  post
     * @author  honglifeng
     */
    public function actionGetHomeAllActivityList(){
        $home_activity = HomeActivity::find()->where(" status =".HomeActivity::STATUS_UP)->orderBy(['updated_at'=>SORT_DESC])->asArray()->all();
        if(false == $home_activity){
            return [
                'code'=>0,
                'data'=>[
                    'item'=>[],
                ]
            ];
        }

        $data = [];
        foreach($home_activity as $item){
            $data[$item['type']] = [
                'title'=>$item['title'],
                'subtitle'=>$item['subtitle'],
                'url'=>$item['url'],
                'pic_url'=>$item['pic_url'],
                'sign_one'=>$item['sign_one'],
                'sign_two'=>$item['sign_two'],
            ];
        }

        return [
            'code'=>0,
            'data'=>[
                'item'=>$data,
            ]
        ];
    }

    /**
     * 获取活动列表
     *
     * @name 获取活动列表 [homeGetActivityList]
     * @method  post
     * @param string $type 活动类型：1、首页banner；2、首页导航；3、首页热门
     * @author  honglifeng
     */

    public function actionGetActivityList(){

        $type = intval($this->request->post('type'),0);
        if(empty($type)){
            return [
                'code'=>-1,
                'message'=>'参数丢失'
            ];
        }
        $home_activity = HomeActivity::find()->where(" type=".$type." and status =".HomeActivity::STATUS_UP)->orderBy(['updated_at'=>SORT_DESC])->asArray()->all();

        if(false == $home_activity){
            return [
                'code'=>0,
                'message'=>'success',
                'data'=>[
                    'item'=>[],
                ]
            ];
        }
        $data = [];
        foreach($home_activity as $item){
            $data[] = [
                'title'=>$item['title'],
                'subtitle'=>$item['subtitle'],
                'url'=>$item['url'],
                'pic_url'=>$item['pic_url'],
                'sign_one'=>$item['sign_one'],
                'sign_two'=>$item['sign_two'],
            ];
        }

        return [
            'code'=>0,
            'message'=>'success',
            'data'=>[
                'item'=>$data,
            ]
        ];
    }





}