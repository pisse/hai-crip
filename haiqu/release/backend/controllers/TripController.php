<?php

namespace backend\controllers;
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\base\Exception;
use common\helpers\ToolsUtil;
use common\models\ProdSpu;


/**
 * Trip controller
 */
class TripController extends BaseController{


    protected function getFilterCondition()
    {
        $search = array();
        $condition = '1=1';
        if ($this->request->get('search_submit')) {
            $search = $this->request->get();
            if ($search['spu_id'] != '') {
                $condition .= " AND spu_id LIKE '%" . trim($search['spu_id']) . "%'";
            }
            if ($search['title'] != '') {
                $condition .= " AND title LIKE '%" . trim($search['title']) . "%'";
            }
            if ($search['spu_type'] != '') {
                $condition .= " AND spu_type = " . intval($search['spu_type']);
            }
            if ($search['spu_nature'] != '') {
                $condition .= " AND spu_nature = " . intval($search['spu_nature']);
            }
        }
        return $condition;
    }

    /**
     * 行程列表
     */
    public function actionList(){
        $condition = $this->getFilterCondition();
        // 判断是否自动发布
        $search = array();
        if ($this->request->get('search_submit')) {
            $search = $this->request->get();

            if (!empty($search['begintime'])) {
                $condition .= " AND updated_at >= " . strtotime($search['begintime']);
            }
            if (!empty($search['endtime'])) {
                $condition .= " AND updated_at <= " . strtotime($search['endtime']);
            }
        }
        $query = ProdSpu::find()->where($condition)->orderBy('spu_id desc');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 15;
        $data = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list', [
            'data' => $data,
            'pages' => $pages,
        ]);
    }

    /**
     * 创建行程，spu
     */
    public function actionAdd(){

        $model = new ProdSpu();
      //  $id = ToolsUtil::createOrderId("SPU");
       // $model->spu_id = $id;
        $model->spu_type = 0;
        $model->spu_nature = 0;
        $model->title = "";
        $model->promotion = "";
        $model->intro = "";
        $model->price_adult = 0;
        $model->price_kid = 0;
        $model->place_gather = 0;
        $model->place_destination = 0;
        $model->intro_destination = "";
        $model->days_travel = 0;
        $model->pic_num = 0;
        $model->pic_main = "";
        $model->pic_little = "";
        $model->line_intro = "";
        $model->activity_intro = "";
        $model->enter_intro = "";
        $model->group_notice = "";
        $model->fee_intro = "";
        $model->sth_notice = "";
        $model->enter_notice = "";
        $model->group_notice = "";
        $model->supplier = "";
        if ($model->load($this->request->post()) && $model->validate()){
            $trip = $this->request->post();
            $trip = $trip['ProdSpu'];
            $id = ToolsUtil::createOrderId("SPU");
            $model->spu_id = $id;
            if(isset($trip['spu_type'])&&isset(ProdSpu::$spu_type_list[$trip['spu_type']])){
                $model->spu_type = $trip['spu_type'];
            }else{
                return $this->redirectMessage('请选择旅游类型', self::MSG_ERROR);
            }
            if(isset($trip['spu_nature'])&&isset(ProdSpu::$spu_nature_list[$trip['spu_nature']])){
                $model->spu_nature = $trip['spu_nature'];
            }else{
                return $this->redirectMessage('请选择旅游性质', self::MSG_ERROR);
            }
            if(isset($trip['title'])&&!empty($trip['title'])){
                $model->title = $trip['title'];
            }else{
                return $this->redirectMessage('请填写产品标题', self::MSG_ERROR);
            }
            if(isset($trip['promotion'])&&!empty($trip['promotion'])){
                $model->promotion = $trip['promotion'];
            }else{
                return $this->redirectMessage('请填写促销语', self::MSG_ERROR);
            }
            if(isset($trip['intro'])&&!empty($trip['intro'])){
                $model->intro = $trip['intro'];
            }else{
                return $this->redirectMessage('请填写产品简介', self::MSG_ERROR);
            }
            if(isset($trip['price_adult'])&&!empty($trip['price_adult'])){
                $model->price_adult = intval($trip['price_adult']*100);
            }else{
                return $this->redirectMessage('请填写成人价', self::MSG_ERROR);
            }
            if(isset($trip['price_kid'])&&!empty($trip['price_kid'])){
                $model->price_kid = intval($trip['price_kid']*100);
            }else{
                return $this->redirectMessage('请填写儿童价', self::MSG_ERROR);
            }
            if(isset($trip['place_gather'])&&!empty($trip['place_gather'])){
                $model->place_gather = $trip['place_gather'];
            }else{
                return $this->redirectMessage('请填写集合地', self::MSG_ERROR);
            }
            if(isset($trip['place_destination'])&&!empty($trip['place_destination'])){
                $model->place_destination = $trip['place_destination'];
            }else{
                return $this->redirectMessage('请填写目的地', self::MSG_ERROR);
            }
            if(isset($trip['intro_destination'])&&!empty($trip['intro_destination'])){
                $model->intro_destination = $trip['intro_destination'];
            }else{
                return $this->redirectMessage('请填写目的地介绍', self::MSG_ERROR);
            }
            if(isset($trip['days_travel'])&&!empty($trip['days_travel'])){
                $model->days_travel = intval($trip['days_travel']);
            }else{
                return $this->redirectMessage('请填写行程天数', self::MSG_ERROR);
            }

            if(isset($trip['pic_num'])&&!empty($trip['pic_num'])){
                $model->pic_num = $trip['pic_num'];
            }else{
                return $this->redirectMessage('请填写图片数量', self::MSG_ERROR);
            }
            if(isset($trip['pic_main'])&&!empty($trip['pic_main'])){
                $model->pic_main = $trip['pic_main'];
            }else{
                return $this->redirectMessage('请填写主图url', self::MSG_ERROR);
            }
            if(isset($trip['pic_little'])&&!empty($trip['pic_little'])){
                $model->pic_little = $trip['pic_little'];
            }else{
                return $this->redirectMessage('请填写缩略图url', self::MSG_ERROR);
            }

            if(isset($trip['line_intro'])&&!empty($trip['line_intro'])){
                $model->line_intro = $trip['line_intro'];
            }else{
                return $this->redirectMessage('请填写线路亮点', self::MSG_ERROR);
            }
            if(isset($trip['activity_intro'])&&!empty($trip['activity_intro'])){
                $model->activity_intro = $trip['activity_intro'];
            }else{
                return $this->redirectMessage('请填写活动说明', self::MSG_ERROR);
            }
            if(isset($trip['enter_intro'])&&!empty($trip['enter_intro'])){
                $model->enter_intro = $trip['enter_intro'];
            }else{
                return $this->redirectMessage('请填写报名流程', self::MSG_ERROR);
            }
            if(isset($trip['group_notice'])&&!empty($trip['group_notice'])){
                $model->group_notice = $trip['group_notice'];
            }else{
                return $this->redirectMessage('请填写出团通知', self::MSG_ERROR);
            }
            if(isset($trip['fee_intro'])&&!empty($trip['fee_intro'])){
                $model->fee_intro = $trip['fee_intro'];
            }else{
                return $this->redirectMessage('请填写费用信息', self::MSG_ERROR);
            }
            if(isset($trip['sth_notice'])&&!empty($trip['sth_notice'])){
                $model->sth_notice = $trip['sth_notice'];
            }else{
                return $this->redirectMessage('请填写注意事项', self::MSG_ERROR);
            }
            if(isset($trip['enter_notice'])&&!empty($trip['enter_notice'])){
                $model->enter_notice = $trip['enter_notice'];
            }else{
                return $this->redirectMessage('请填写报名提醒', self::MSG_ERROR);
            }
            if(isset($trip['supplier'])&&!empty($trip['supplier'])){
                $model->supplier = $trip['supplier'];
            }else{
                return $this->redirectMessage('请填写供应商', self::MSG_ERROR);
            }

            $model->created_by = Yii::$app->user->identity->username;
            $model->updated_at = date("Y-m-d H:i:s",time());
            $model->created_at = date("Y-m-d H:i:s",time());
            if($model->save()){
                return $this->redirectMessage('创建成功', self::MSG_SUCCESS, Url::toRoute('trip/add'));
            }else{
                return $this->redirectMessage('创建失败', self::MSG_ERROR);
            }


        }
        return $this->render('add', [
            'model' => $model,
        ]);




    }

}
