<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use backend\controllers\BaseController;
use backend\models\ActionModel;
use backend\models\DocumentApi;
use common\models\Order;

/**
 * Document controller
 */
class DocumentController extends BaseController
{
	public $layout = false;
	
	public $verifyPermission = false;
	
	/**
	 * 文档首页
	 */
	public function actionApi()
	{
		$action = $this->request->get('action');
		$navItems = [];
		$currentAction = null;
		$debugRoute = $debugUrl = '';
		$configs = Yii::$app->params['apiList'];
		foreach ($configs as $config) {
			$items = [];
			$rf = new \ReflectionClass($config['class']);
			$methods = $rf->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($methods as $method) {
				if (strpos($method->name, 'action') === false || $method->name == 'actions') {
					continue;
				}
				$actionModel = new ActionModel($method);
				$active = false;
				if ($action) {
					list($class, $actionName) = explode('::', $action);
					if ($class == $config['class'] && $actionName == $method->name) {
						$currentAction = $actionModel;
						$debugRoute = $actionModel->getRoute();
						$debugUrl = str_replace(
							['backend', 'admin.668ox.com'],
							['frontend', 'api.668ox.com'],
							$this->request->getHostInfo() . $this->request->getBaseUrl()
						) . '/' . $debugRoute;
						
						$active = true;
					}
				}
				
				$items[] = [
					'label' => $actionModel->getTitle(),
					'url' => Url::to(['document/api', 'action' => "{$config['class']}::{$method->name}"]),
					'active' => $active,
				];
			}
			$navItems[] = [
				'label' => $config['label'],
				'url' => '#',
				'items' => $items
			];
		}
		if ($currentAction) {
			$api = DocumentApi::findOne(['name' => $action]);
			$api || $api = new DocumentApi();
			$currentAction->data = [
				'response' => $api->response,
				'desc' => $api->desc,
			];
		}
		return $this->render('api', [
			'action' => $action,
			'navItems' => $navItems,
			'model' => $currentAction,
			'debugRoute' => $debugRoute,
			'debugUrl' => $debugUrl,
		]);
	}
	
	/**
	 * 保存接口文档信息
	 */
	public function actionApiSave($action)
	{
		$this->response->format = Response::FORMAT_JSON;
		$model = DocumentApi::findOne(['name' => $action]);
		if (!$model) {
			$model = new DocumentApi();
		}
		if ($model->load($this->request->post()) && $model->validate()) {
			$model->name = $action;
			if ($model->save()) {
				return ['result' => true];
			}
		}
		return ['result' => false];
	}
	
	/**
	 * 在线调试，目前只支持frontend下的controller
	 * @param string $route
	 */
	public function actionApiDebug($route)
	{
		$this->layout = "@backend/views/document/debug";
		try {
			$route = trim($route, '/');
			// 通过路由找到controller和action名称
			list($controllerId, $actionId) = explode('/', $route);
			$className = str_replace(' ', '', ucwords(str_replace('-', ' ', $controllerId)));
			$actionName = str_replace(' ', '', ucwords(str_replace('-', ' ', $actionId)));
			$class = "frontend\\controllers\\" . $className . "Controller";
			$action = "action" . $actionName;
		
			$rf = new \ReflectionClass($class);
			$method = $rf->getMethod($action);
			$actionModel = new ActionModel($method);
		} catch (\Exception $e) {
			return '无对应的Controller或Action，请检测route参数是否正确';
		}
		
		$debugUrl = str_replace('backend', 'frontend', $this->request->getBaseUrl()) . '/' . $route;
		return $this->render('_debug', [
			'debugUrl' => $debugUrl,
			'route' => $route,
			'model' => $actionModel,
		]);
	}
	
	/**
	 * 获取签名
	 */
	public function actionGetSign()
	{
		$params = $this->request->post();
		unset($params['sign']);
		unset($params[Yii::$app->getRequest()->csrfParam]);
		return Order::getSign($params);
	}
}