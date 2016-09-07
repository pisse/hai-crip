<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\models\AdminUser;
use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/**
 * @var backend\components\View $this
 */
$this->shownav('system', 'menu_adminuser_list');
$this->showsubmenu('管理员管理', array(
	array('列表', Url::toRoute('admin-user/list'), 1),
	array('添加管理员', Url::toRoute('admin-user/add'), 0),
));

?>
<?php $form = ActiveForm::begin(['id' => 'searchform','method'=>'get', 'options' => ['style' => 'margin-bottom:5px;']]); ?>
	用户名关键词：<input type="text" value="<?php echo Yii::$app->getRequest()->get('username', ''); ?>" name="username" class="txt" style="width:120px;">&nbsp;
	手机号关键词：<input type="text" value="<?php echo Yii::$app->getRequest()->get('phone', ''); ?>" name="phone" class="txt" style="width:120px;">&nbsp;
    角色：<?php echo Html::dropDownList('role', Yii::$app->getRequest()->get('role', ''), $role_lsit, ['prompt' => '所有角色']); ?>&nbsp;
	<input type="submit" name="search_submit" value="过滤" class="btn">
<?php ActiveForm::end(); ?>

<table class="tb tb2 fixpadding">
	<tr class="header">
		<th>ID</th>
		<th>用户名</th>
		<th>手机号</th>
		<th>角色</th>
		<th>创建人</th>
		<th>创建时间</th>
		<th>备注/姓名</th>
		<th>操作</th>
	</tr>
	<?php foreach ($users as $value): ?>
	<tr class="hover">
		<td class="td25"><?php echo $value->id; ?></td>
		<td class="td25"><?php echo $value->username; ?></td>
		<td class="td25"><?php echo $value->phone; ?></td>
		<td class="td25" style="word-wrap: break-word; word-break: normal;word-break:break-all; "><?php echo $value->role; ?></td>
		<td class="td25"><?php echo $value->created_user; ?></td>
		<td class="td25"><?php echo date('Y-m-d', $value->created_at); ?></td>
		<td class="td25"><?php echo $value->mark; ?></td>
		<td class="td24">
			<a href="<?php echo Url::to(['admin-user/change-pwd', 'id' => $value->id]); ?>">修改密码</a>
			<?php if ($value->username != AdminUser::SUPER_USERNAME): ?>
			<a href="<?php echo Url::to(['admin-user/edit', 'id' => $value->id]); ?>">编辑</a>
			<a onclick="return confirmMsg('确定要删除吗？');" href="<?php echo Url::to(['admin-user/delete', 'id' => $value->id]); ?>">删除</a>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php echo LinkPager::widget(['pagination' => $pages]); ?>