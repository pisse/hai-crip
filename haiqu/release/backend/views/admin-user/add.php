<?php

use yii\helpers\Url;

/**
 * @var backend\components\View $this
 */
$this->shownav('system', 'menu_adminuser_list');
$this->showsubmenu('管理员管理', array(
	array('列表', Url::toRoute('admin-user/list'), 0),
	array('添加管理员', Url::toRoute('admin-user/add'), 1),
));

?>

<?php echo $this->render('_form', [
	'model' => $model,
	'roles' => $roles,
]); ?>