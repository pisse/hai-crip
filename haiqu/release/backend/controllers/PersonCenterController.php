<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/18 0018
 * Time: 23:21
 */
namespace backend\controllers;

use common\models\Order;
use common\models\User;
use common\models\UserMember;
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\base\Exception;

class PersonCenterController extends BaseController{

    protected function getFilter() {
        $condition = '1 = 1';
        if ($this->getRequest()->getIsGet()) {
            $search = $this->request->get();
            if (isset($search['id']) && !empty($search['id'])) {
                $condition .= " AND id = " . intval($search['id']);
            }
            if (isset($search['title']) && !empty($search['title'])) {
                $condition .= " AND title LIKE '%" . trim($search['title']) . "%'";
            }
            if (isset($search['type']) && !empty($search['type'])) {
                $condition .= " AND type = " . intval($search['type']);
            }
            if (isset($search['status'])) {
                $condition .= " AND status = " . intval($search['status']);
            }
        }
        return $condition;
    }

    //会员申请列表
    public function actionMemberList(){

        $condition = $this->getFilter();
        $query = UserMember::find()->from(UserMember::tableName().' as l')->innerJoin(User::tableName().' as q','l.user_id=q.id')->where($condition)->select('l.*,q.*')->asArray()->orderby('l.updated_at desc');
        $query = UserMember::find()->where($condition)->orderBy(['updated_at'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 20;
        $user_member = $query->offset($pages->offset)->limit($pages->limit)->all();
     //   var_dump($user_member);exit;

        return $this->render('member-list', array(
            'user_member' => $user_member,
            'pages' => $pages,
        ));
    }

    /**
     * 配置微信公号
     * @return bool
     */
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = "weixin";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return $_GET["echostr"];
        }else{
            return false;
        }
    }

    public function actionOrderList() {

        $condition = '1 = 1';
        if ($this->getRequest()->getIsGet()) {
            $search = $this->request->get();
            if (isset($search['order_id']) && !empty($search['order_id'])) {
                $condition .= " AND order_id = " . intval($search['order_id']);
            }
            if (isset($search['status'])) {
                $condition .= " AND status = " . intval($search['status']);
            }
        }
        $query = Order::find()->where($condition)->orderBy(['updated_at'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 24;
        $orders = $query->offset($pages->offset)->limit($pages->limit)->all();

        /**
         * wecaht sdk test
         */
//        $echoStr = $_GET["echostr"];
//
//        //valid signature , option
//        if($this->checkSignature()){
//            echo $echoStr;
//            exit;
//        }
//        include ("/data/htdocs/release/vendor/callmez/yii2-wechat-sdk/Wechat.php");
//        $wechat = Yii::$app->wechat;
//        var_dump($wechat->getMemberList());
//
//        $openID = "oYKr6wZ-PM6sVu6pR7XkmqcRdLXY";
//        var_dump($wechat->getMemberInfo($openID));
//
//        exit;
        return $this->render('order-list', array(
            'order_list' => $orders,
            'pages' => $pages,
        ));
    }
}