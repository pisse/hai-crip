<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Base controller
 *
 * @property \yii\web\Request $request The request component.
 * @property \yii\web\Response $response The response component.
 */
abstract class BaseController extends Controller
{
	const MSG_NORMAL = 0;
	const MSG_SUCCESS = 1;
	const MSG_ERROR = 2;

	// 是否验证本系统的权限逻辑
	public $verifyPermission = true;

	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (Yii::$app->request->get('frames')) {
				$this->redirect(['main/index', 'action' => $this->getRoute()]);
				return false;
			}

			if ($this->verifyPermission) {
				// 验证登录
				if (Yii::$app->user->getIsGuest()) {
					return $this->redirect(['main/login']);
				}
				// 验证权限
				if (!Yii::$app->user->identity->getIsSuperAdmin()) {
					$permissions = Yii::$app->getSession()->get('permissions');
					if ($permissions) {
						$permissions = json_decode($permissions, true);
						if (!in_array($this->getRoute(), $permissions)) {
							throw new ForbiddenHttpException('您所属的管理员角色无此权限');
						}
					} else {
						throw new ForbiddenHttpException('您所属的管理员角色无此权限');
					}
				}
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获得请求对象
	 */
	public function getRequest()
	{
		return \Yii::$app->getRequest();
	}

	/**
	 * 获得返回对象
	 */
	public function getResponse()
	{
		return \Yii::$app->getResponse();
	}

	/**
	 * 跳转到提示页面
	 * @param string $message	提示语
	 * @param int $msgType		提示类型，不同提示类型提示语样式不一样
	 * @param string $url		自动跳转url地址，不设置则默认显示返回上一页连接
	 * @return string
	 */
	public function redirectMessage($message, $msgType = self::MSG_NORMAL, $url = '')
	{
		switch ($msgType) {
			case self::MSG_SUCCESS: $messageClassName = 'infotitle2';break;
			case self::MSG_ERROR: $messageClassName = 'infotitle3';break;
			default: $messageClassName = 'marginbot normal';break;
		}
		return $this->render('/message', array(
			'message' => $message,
			'messageClassName' => $messageClassName,
			'url' => $url,
		));
	}
}