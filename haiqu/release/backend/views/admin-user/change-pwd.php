<?php

use yii\helpers\Url;
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

<?php $form = ActiveForm::begin(['id' => 'admin-form']); ?>
<table class="tb tb2">
	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'username'); ?></td></tr>
	<tr class="noborder">
		<td colspan="2"><?php echo $model->username; ?></td>
	</tr>
	<tr><td class="td27" colspan="2"><font color="red">*</font>新密码：</td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']); ?></td>
		<td class="vtop tips2">密码为6-16位字符或数字</td>
	</tr>
	<tr>
		<td colspan="15">
			<input type="submit" value="提交" name="submit_btn" class="btn">
		</td>
	</tr>
</table>
<?php ActiveForm::end(); ?>