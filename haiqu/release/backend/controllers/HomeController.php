<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/8/17
 * Time: 17:16
 */
namespace backend\controllers;

use common\models\HomeActivity;
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\base\Exception;

class HomeController extends BaseController{


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

    /**
     * 首页活动列表
     */
    public function actionList(){

        $condition = $this->getFilter();
        $query = HomeActivity::find()->where($condition)->orderBy(['updated_at'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 20;
        $home_activity = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list', array(
            'home_activity' => $home_activity,
            'pages' => $pages,
        ));
    }

    /**
     *
     */
    public function actionUpdate($id,$status){
        $home_activity = HomeActivity::findOne(['id'=>$id]);
        if(false == $home_activity){
            return $this->redirectMessage('操作失败', self::MSG_ERROR);
        }

        $home_activity->status = $status;
        $home_activity->updated_at = time();
        $home_activity->operator_name = Yii::$app->user->identity->username;

        if(!$home_activity->save()){
            return $this->redirectMessage('置顶失败', self::MSG_ERROR);
        }

        return $this->redirectMessage('操作成功', self::MSG_SUCCESS, Url::toRoute(['home/list']));
    }

    /**
     * 置顶
     */
    public function actionTop($id){

        $home_activity = HomeActivity::findOne(['id'=>$id]);
        if(false == $home_activity){
            return $this->redirectMessage('置顶失败', self::MSG_ERROR);
        }

        $home_activity->updated_at = time();
        $home_activity->operator_name = Yii::$app->user->identity->username;

        if(!$home_activity->save()){
            return $this->redirectMessage('置顶失败', self::MSG_ERROR);
        }

        return $this->redirectMessage('操作成功', self::MSG_SUCCESS, Url::toRoute(['home/list']));
    }

    /**
     * 首页banner添加
     */
    public function actionBannerAdd(){

        $home_activity = new HomeActivity();

        if($home_activity->load($this->request->post()) && $home_activity->validate()){
            try{
                $post = Yii::$app->request->post("HomeActivity");
                if(isset($post['type'])&&!empty($post['type'])){
                    $home_activity->type = $post['type'];
                }else{
                    return $this->redirectMessage('请选择活动类型', self::MSG_ERROR);
                }

                if(isset($post['title'])&&!empty($post['title'])){
                    $home_activity->title = $post['title'];
                }else{
                    return $this->redirectMessage('请填写活动标题', self::MSG_ERROR);
                }

                if(isset($post['url'])&&!empty($post['url'])){
                    $home_activity->url = $post['url'];
                }else{
                    return $this->redirectMessage('请填写活动标题', self::MSG_ERROR);
                }

                if(isset($post['pic_url'])&&!empty($post['pic_url'])){
                    $home_activity->pic_url = $post['pic_url'];
                }else{
                    return $this->redirectMessage('请填写图片地址', self::MSG_ERROR);
                }
                $home_activity->subtitle = $post['subtitle'];
                $home_activity->sign_one = $post['sign_one'];
                $home_activity->sign_two = $post['sign_two'];
                $home_activity->updated_at = time();
                $home_activity->created_at = time();
                $home_activity->status = HomeActivity::STATUS_PENDING;
                $home_activity->operator_name = Yii::$app->user->identity->username;

                if(!$home_activity->save()){
                    return $this->redirectMessage('添加失败', self::MSG_ERROR);
                }

                return $this->redirectMessage('添加成功', self::MSG_SUCCESS, Url::toRoute('home/banner-add'));

            }catch (Exception $e){
                return $this->redirectMessage($e->getMessage(), self::MSG_ERROR);
            }
        }

        return $this->render('home-banner-add', [
                'home_activity' => $home_activity,
            ]
        );

    }


}