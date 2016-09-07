<?php
namespace backend\controllers;

use common\models\Version;
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use backend\models\AdminUserRole;
use backend\models\ActionModel;
use backend\models\AdminUser;

/**
 * AdminUser controller
 */
class VersionController extends BaseController{

	/**
	 * 版本控制
	 */
	public function actionSetting(){

		$version_info = Version::findOne(['id'=>100,'type'=>1]);
		if(false == $version_info){
			exit;
		}


		$version_info->id = 100;
		$version_info->type = 1;
		$version_info->has_upgrade = $version_info->has_upgrade;
		$version_info->is_force_upgrade = $version_info->is_force_upgrade;
		$version_info->new_version = $version_info->new_version;
		$version_info->new_ios_version = $version_info->new_ios_version;
		$version_info->new_features = $version_info->new_features;
		$version_info->ard_url = $version_info->ard_url;
		$version_info->ard_size = $version_info->ard_size;

		if ($version_info->load($this->request->post()) && $version_info->validate()) {
			$version_info->id = 100;
			$version_info->type = 1;
			$version_info->has_upgrade = $version_info->has_upgrade;
			$version_info->is_force_upgrade = $version_info->is_force_upgrade;
			$version_info->new_version = $version_info->new_version;
			$version_info->new_ios_version = $version_info->new_ios_version;
			$version_info->new_features = $version_info->new_features;
			$version_info->ard_url = $version_info->ard_url;
			$version_info->ard_size = $version_info->ard_size;
			$version_info->update_time = time();
			$version_info->operator_name = Yii::$app->user->identity->username;
			if(!$version_info->save()){
				return $this->redirectMessage('保存失败', self::MSG_ERROR, Url::toRoute('version/setting'));
			}
			return $this->redirectMessage('保存成功', self::MSG_SUCCESS, Url::toRoute('version/setting'));
		}

		return $this->render('setting', [
			'version_info' => $version_info,
		]);


	}

}