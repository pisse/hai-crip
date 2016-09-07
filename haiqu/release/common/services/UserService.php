<?php
namespace common\services;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/7/10
 * Time: 14:11
 */
use common\models\User;
use common\models\UserPassword;
use Yii;
use yii\base\Exception;
use yii\base\Object;

class UserService extends  Object
{
    public function __construct( $config = [])
    {
        parent::__construct($config);
    }

    /**
     * 通过手机号注册
     */
    public function registerByPhone($phone, $password, $source = 0){

        $connect = Yii::$app->db;
        $transaction = $connect->beginTransaction();
        try{
            $user = User::findOne(['mobile'=>$phone]);
            if(false === $user){
                $transaction->rollBack();
                return false;
            }elseif ($user){
                $transaction->rollBack();
                return false;
            }else{
                $user = new User();
            }
            $user->username = $phone;
            $user->mobile = $phone;
            $user->source = $source;
            $user->status = User::STATUS_ACTIVE;
            $user->created_at = time();
            $user->updated_at = time();
            $user->created_ip = Yii::$app->getRequest()->getUserIP();
            $user->generateAuthKey();

            if(!$user->save()){
                $transaction->rollBack();
                return false;
            }

            $user_password = UserPassword::findOne(['user_id'=>$user->id]);

            if(false === $user_password){
                $transaction->rollBack();
                return false;
            }elseif ($user_password){
                $transaction->rollBack();
                return false;
            }else{
                $user_password = new UserPassword();
            }
            $user_password->user_id = $user->id;
            $user_password->password = md5(md5(UserPassword::MD5_STRING.$password));
            $user_password->created_at = time();
            $user_password->updated_at = time();
            if(!$user_password->save()){
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();

            return $user;


        }catch (\Exception $e){
            $transaction->rollBack();

            return false;
        }
    }


}
