<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use backend\models\AdminUserRole;
use backend\models\ActionModel;
use backend\models\AdminUser;

/**
 * AdminUser controller
 */
class AdminUserController extends BaseController
{
	/**
	 * 管理员列表
	 * 
	 * @name 显示管理员列表
	 */
	public function actionList()
	{
		$search = [];
		$condition = '1=1';
		if ($this->request->get('search_submit')) { // 过滤
			$search = $this->request->get();
            if (isset($search['phone']) && $search['phone'] != '') {
                $condition .= " AND phone LIKE '%" . trim($search['phone']) . "%'";
            }
            if (isset($search['username']) && $search['username'] != '') {
                $condition .= " AND username LIKE '%" . trim($search['username']) . "%'";
            }
            if (isset($search['role']) && $search['role'] != '') {
                $condition .= " AND role LIKE '%" . trim($search['role'])."%'";
            }
		}

		$query = AdminUser::find()->where($condition)->orderBy('id desc');
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$pages->pageSize = 15;
		$users = $query->offset($pages->offset)->limit($pages->limit)->all();
		$role_lsit = [];
		$role_lsit_temp = AdminUserRole::find()->select(['name','title'])->asArray()->all();
		foreach ($role_lsit_temp as $v) {
			$role_lsit[$v['name']] = $v['name'].'------'.$v['title'];
		}

		return $this->render('list', [
			'users' => $users,
			'role_lsit' => $role_lsit,
			'pages' => $pages,
		]);
	}
	
	/**
	 * 添加管理员
	 * 
	 * @name 添加管理员
	 */
	public function actionAdd()
	{
		$model = new AdminUser();
		$roles = $this->request->post('roles');
		if($roles){
			$model->role = implode(',',$roles);
		}
		if ($model->load($this->request->post()) && $model->validate()) {
			$model->created_user = Yii::$app->user->identity->username;
			$model->password = Yii::$app->security->generatePasswordHash($model->password);
			if ($model->save(false)) {
				return $this->redirectMessage('添加成功', self::MSG_SUCCESS, Url::toRoute('admin-user/list'));
			} else {
				return $this->redirectMessage('添加失败', self::MSG_ERROR);
			}
		}

		$roles = AdminUserRole::findAllSelected();
		return $this->render('add', [
			'model' => $model,
			'roles' => $roles,
		]);
	}
	
	/**
	 * 编辑管理员
	 *
	 * @name 编辑管理员
	 */
	public function actionEdit($id)
	{
		$model = AdminUser::findOne(intval($id));
		if (!$model || $model->username == AdminUser::SUPER_USERNAME) {
			return $this->redirectMessage('不存在或者不可编辑', self::MSG_ERROR);
		}
		
		// 不验证密码
		$roles = $this->request->post('roles');
		if($roles){
			$model->role = implode(',',$roles);
		}
		if ($model->load($this->request->post()) && $model->validate(['role','phone'])) {
			if ($model->save(false)) {
				return $this->redirectMessage('编辑成功', self::MSG_SUCCESS, Url::toRoute('admin-user/list'));
			} else {
				return $this->redirectMessage('编辑失败', self::MSG_ERROR);
			}
		}
		
		$roles = AdminUserRole::findAllSelected();

		return $this->render('edit', [
			'model' => $model,
			'roles' => $roles,
		]);
	}
	
	/**
	 * 修改密码
	 * 
	 * @name 修改密码
	 */
	public function actionChangePwd($id)
	{
		$model = AdminUser::findOne(intval($id));
		if (!$model) {
			return $this->redirectMessage('不存在', self::MSG_ERROR);
		}
		
		$model->password = '';
		if ($model->load($this->request->post()) && $model->validate(['password'])) {
			$model->password = Yii::$app->security->generatePasswordHash($model->password);
			if ($model->save(false)) {
				return $this->redirectMessage('修改成功', self::MSG_SUCCESS, Url::toRoute('admin-user/list'));
			} else {
				return $this->redirectMessage('修改失败', self::MSG_ERROR);
			}
		}
		
		return $this->render('change-pwd', [
			'model' => $model,
		]);
	}
	
	/**
	 * 删除管理员
	 *
	 * @name 删除管理员
	 */
	public function actionDelete($id)
	{
		$model = AdminUser::findOne(intval($id));
		if (!$model || $model->username == AdminUser::SUPER_USERNAME) {
			return $this->redirectMessage('不存在或者不可删除', self::MSG_ERROR);
		}
		$model->delete();
		return $this->redirect(['admin-user/list']);
	}
	
	/**
	 * 角色列表
	 * 不用分页
	 * 
	 * @name 显示角色列表
	 */
	public function actionRoleList()
	{
		$roles = AdminUserRole::find()->all();
		$groups = AdminUserRole::$status;
		return $this->render('role-list', [
			'roles' => $roles,
			'groups' => $groups,
		]);
	}
	
	/**
	 * 添加角色
	 * 
	 * @name 添加角色
	 */
	public function actionRoleAdd()
	{
		$model = new AdminUserRole();
		
		if ($model->load($this->request->post())) {
			$postPermissions = $this->request->post('permissions');
			$model->permissions = $postPermissions ? json_encode($postPermissions) : '';
			$model->created_user = Yii::$app->user->identity->username;
			$AdminUserRole = $this->request->post('AdminUserRole');
			$model->groups =$AdminUserRole['groups']?intval($AdminUserRole['groups']):0;
			
			if ($model->validate()) {
				if ($model->save()) {
					return $this->redirectMessage('添加成功', self::MSG_SUCCESS, Url::toRoute('admin-user/role-list'));
				} else {
					return $this->redirectMessage('添加失败', self::MSG_ERROR);
				}
			}
		}
		
		$controllers = Yii::$app->params['permissionControllers'];
		$permissions = [];
		foreach ($controllers as $controller => $label) {
			$actions = [];
			$rf = new \ReflectionClass("backend\\controllers\\{$controller}");
			$methods = $rf->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($methods as $method) {
				if (strpos($method->name, 'action') === false || $method->name == 'actions') {
					continue;
				}
				$actions[] = new ActionModel($method);
			}
			$permissions[$controller] = [
				'label' => $label,
				'actions' =>$actions,
			];
		}
		
		$permissionChecks = $model->permissions ? json_decode($model->permissions, true) : [];
		
		$groups = AdminUserRole::$status;

		return $this->render('role-add', [
			'model' => $model,
			'permissions' => $permissions,
			'permissionChecks' => $permissionChecks,
			'groups' => $groups,
		]);
	}
	
	/**
	 * 编辑角色
	 *
	 * @name 编辑角色
	 */
	public function actionRoleEdit($id)
	{
		$model = AdminUserRole::findOne(intval($id));
		if (!$model || $model->name == AdminUser::SUPER_ROLE) {
			return $this->redirectMessage('不存在或者不可编辑', self::MSG_ERROR);
		}
	
		if ($model->load($this->request->post())) {
			$postPermissions = $this->request->post('permissions');
			$model->permissions = $postPermissions ? json_encode($postPermissions) : '';
			if ($model->validate()) {
				if ($model->save()) {
					return $this->redirectMessage('编辑成功', self::MSG_SUCCESS, Url::toRoute('admin-user/role-list'));
				} else {
					return $this->redirectMessage('编辑失败', self::MSG_ERROR);
				}
			}
		}
	
		$controllers = Yii::$app->params['permissionControllers'];
		$permissions = [];
		foreach ($controllers as $controller => $label) {
			$actions = [];
			$rf = new \ReflectionClass("backend\\controllers\\{$controller}");
			$methods = $rf->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($methods as $method) {
				if (strpos($method->name, 'action') === false || $method->name == 'actions') {
					continue;
				}
				$actions[] = new ActionModel($method);
			}
			$permissions[$controller] = [
				'label' => $label,
				'actions' =>$actions,
			];
		}
	
		$permissionChecks = $model->permissions ? json_decode($model->permissions, true) : [];
	
		return $this->render('role-edit', [
			'model' => $model,
			'permissions' => $permissions,
			'permissionChecks' => $permissionChecks,
		]);
	}
	
	/**
	 * 删除角色
	 * 
	 * @name 删除角色
	 */
	public function actionRoleDelete($id)
	{
		$model = AdminUserRole::findOne(intval($id));
		if (!$model || $model->name == AdminUser::SUPER_ROLE) {
			return $this->redirectMessage('不存在或者不可删除', self::MSG_ERROR);
		}
		AdminUser::updateAll(['role' => ''], ['role' => $model->name]);
		$model->delete();
		return $this->redirect(['admin-user/role-list']);
	}
}