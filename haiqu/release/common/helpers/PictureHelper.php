<?php

namespace common\helpers;

use common\models\UserProofMateria;
use Yii;

class PictureHelper
{
    /**
     * 根据用户ID和类型获取图片列表
     * @param $user_id 用户ID
     * @param $type 1:身份证,2:学历证明,3:工作证明,4:薪资证明,5:财产证明,100:其它证明 等等
     */

    public static function getPicList($user_id,$type){
        $curUser = Yii::$app->user->identity;

        $id         =   $curUser->getId();
        if($id != $user_id){
            return false;
        }
        $user_proof_materia = UserProofMateria::find()->where(['user_id'=>$user_id,'type'=>$type])->all();
        if(false === $user_proof_materia){
            return false;
        }
        $data = array();
        foreach($user_proof_materia as $item){
            $data[] = [
                'id'=>$item['id'],
                'pic_name'=>$item['pic_name'],
                'type'=>$item['type'],
                'url'=>$item['url'],
            ];
        }

        return $data;
    }

}