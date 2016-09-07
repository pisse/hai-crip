<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/6/11
 * Time: 11:59
 */
namespace backend\controllers;

use common\models\UserCompanyOperateLog;
use common\models\UserLoginUploadLog;
use common\models\UserOperateLog;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\Url;
use yii\redis\ActiveQuery;

class LogController extends  BaseController{

    protected function getFilter() {
        $condition = '1 = 1';
        if ($this->getRequest()->getIsGet()) {
            $search = $this->request->get();
            if(isset($search['user_id'])&&!empty($search['user_id'])){
                $condition .= " AND user_id = " . intval($search['user_id']);
            }
            if(isset($search['deviceId'])&&!empty($search['deviceId'])){
                $condition .= " AND deviceId like '%" . $search['deviceId']."%'";
            }
        }
        return $condition;
    }


    /**
     * @return 获取登录信息
     */
    public function  actionYgbLoginLogList(){


        $condition = $this->getFilter();
        $query = UserLoginUploadLog::find()->where($condition)->orderBy([
            'id' => SORT_DESC,
        ]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 15;
        $user_login_upload_log = $query->with([
            'loanPerson' => function(Query $query) {
                $query->select(['id', 'name', 'phone']);
            },
        ])->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('ygb-login-log-list', array(
            'user_login_upload_log' => $user_login_upload_log,
            'pages' => $pages,
        ));
    }

    /**
     * 操作公司日志列表
     * @return string
     */
    public function actionCompanyLogList()
    {
        $condition = "1=1";
        if ($this->getRequest()->getIsGet()) {
            $search = $this->request->get();
            if(isset($search['company_id'])&& !empty($search['company_id'])){
                $condition .= " AND company_id = " . intval($search['company_id']);
            }
            if(isset($search['company_name'])&& !empty($search['company_name'])){
                $condition .= " AND company_name like '%" . $search['company_name']."%'";
            }
            if (isset($search['type']) && $search['type'] != NULL) {
                $condition .= " AND type = '" . $search['type']."'";
            }
        }
        $query = UserCompanyOperateLog::find()->where($condition)->orderBy([
            'id' => SORT_DESC,
        ]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 15;
        $log = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('company-log-list', array(
            'log' => $log,
            'pages' => $pages,
        ));
    }

    /**
     * 操作用户日志列表
     * @return string
     */
    public function actionUserLogList()
    {
        $condition = "1=1";
        if ($this->getRequest()->getIsGet()) {
            $search = $this->request->get();
            if(isset($search['user_id'])&& !empty($search['user_id'])){
                $condition .= " AND user_id = " . intval($search['user_id']);
            }
            if (isset($search['type']) && $search['type'] != NULL) {
                $condition .= " AND type = '" . $search['type']."'";
            }
        }
        $query = UserOperateLog::find()->where($condition)->orderBy([
            'id' => SORT_DESC,
        ]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 15;
        $log = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('user-log-list', array(
            'log' => $log,
            'pages' => $pages,
        ));
    }
}