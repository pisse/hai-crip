<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/8/18
 * Time: 14:38
 */
namespace frontend\controllers;

use common\helpers\ToolsUtil;
use common\models\User;
use common\models\UserMember;
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

class PersonCenterController extends  BaseController{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 除了下面的action其他都需要登录
                'except' => ['get-person-center-info', 'apply-member'],
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
     * 申请会员
     * @name 申请会员 [personCenterApplyMember]
     * @method  post
     * @param integer $user_id 用户ID
     * @param string $name 会员姓名
     * @param string $mobile 会员手机号
     * @param string $weixin_no 会员微信号
     * @author  honglifeng
     */
    public function actionApplyMember(){
        $user_id = intval($this->request->post('user_id'),0);
        if(empty($user_id)){
            return [
                'code'=>-1,
                'message'=>'参数丢失',
            ];
        }
        $name = trim($this->request->post('name'),'');
        if(empty($name)){
            return [
                'code'=>-1,
                'message'=>'请填写会员姓名',
            ];
        }
        $mobile = trim($this->request->post('mobile'),'');
        if(empty($mobile)){
            return [
                'code'=>-1,
                'message'=>'请填写会员手机号',
            ];
        }
        $weixin_no = trim($this->request->post('weixin_no'),'');
        if(empty($weixin_no)){
            return [
                'code'=>-1,
                'message'=>'请填写会员微信号',
            ];
        }
        
        //查询会员是否已经申请过
        $user_member = UserMember::findOne(['user_id'=>$user_id]);
        $user_info = User::findOne(['id'=>$user_id]);
        if(false == $user_info){
            return [
                'code'=>-1,
                'message'=>'获取用户信息失败'
            ];
        }

        if($user_member){
            if(UserMember::STATUS_PENDING <= $user_member->status){
                return [
                    'code'=>-1,
                    'message'=>'你已经申请会员,不必重复申请'
                ];
            }

            $user_member->status = UserMember::STATUS_PENDING;
            $user_member->apply_time = date("Y-m-d H:i:s",time());
            $user_member->updated_at = date("Y-m-d H:i:s",time());
            if(!$user_member->save()){
                return [
                    'code'=>-1,
                    'message'=>'系统繁忙,请稍后再试'
                ];
            }
        }else{
            //不存在，查询一下手机号
            //判断填的手机号和用户手机号是否相对应
            if($mobile != $user_info->mobile){
                return [
                    'code'=>-1,
                    'message'=>'所填的手机号与绑定手机号不一致'
                ];
            }
            if(UserMember::findOne(['weixin_no'=>$weixin_no])){
                return [
                    'code'=>-1,
                    'message'=>'该微信号已经被绑定,请重新填写'
                ];
            }
            $user_member = new  UserMember();
            $user_member->user_id = $user_id;
            $user_member->weixin_no = $weixin_no;
            $user_member->member_level = UserMember::MEMBER_LEVEL_HARDCORE;
            $user_member->menmber_fee = UserMember::$member_level_fee[$user_member->member_level];
            $user_member->status = UserMember::STATUS_PENDING;
            $user_member->apply_time = date("Y-m-d H:i:s",time());
            $user_member->created_at = date("Y-m-d H:i:s",time());
            $user_member->updated_at = date("Y-m-d H:i:s",time());
            if(!$user_member->save()){
                return [
                    'code'=>-1,
                    'message'=>'系统繁忙,请稍后再试'
                ];
            }

        }

        return [
            'code'=>0,
            'message'=>'申请成功,请等待审核'
        ];

    }



    /**
     * 获取个人中心数据
     * @name 获取个人中心数据 [personCenterGetPersonCenterInfo]
     * @method  post
     * @param string $user_id 用户ID
     * @author  honglifeng
     */
    public function actionGetPersonCenterInfo(){
        $data = [
            'userhead'=>'',
            'username'=>'',
            'member_level'=>'',
            'cash_integral'=>0,
            'travel_integral'=>0,
        ];

        $user_id = intval($this->request->post('user_id'),0);
        if(empty($user_id)){
            return [
                'code'=>0,
                'message'=>'success',
                'data'=>[
                    'item'=>$data,
                ],
            ];
        }

        $user_info = User::findOne(['id'=>$user_id]);
        if(false == $user_info){
            return [
                'code'=>0,
                'message'=>'success',
                'data'=>[
                    'item'=>$data,
                ],
            ];
        }

        $data['userhead']=$user_info->userhead;
        $data['username']=$user_info->username;

        $data['member_level'] = isset(UserMember::$member_level[$user_info->member_level])?UserMember::$member_level[$user_info->member_level]:User::$member_level[UserMember::MEMBER_LEVEL_NORMAL];


        return [
            'code'=>0,
            'message'=>'success',
            'data'=>[
                'item'=>$data,
            ],
        ];


    }
}