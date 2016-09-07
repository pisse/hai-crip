<?php
use backend\components\widgets\ActiveForm;
use backend\models\AdminUserRole;

?>

<style type="text/css">
.item{ float: left; width: 180px; line-height: 25px; margin-left: 5px; border-right: 1px #deeffb dotted; }
</style>
<script type="text/JavaScript">
function permcheckall(obj, perms, t) {
	var t = !t ? 0 : t;
	var checkboxs = $id(perms).getElementsByTagName('INPUT');
	for(var i = 0; i < checkboxs.length; i++) {
		var e = checkboxs[i];
		if(e.type == 'checkbox') {
			if(!t) {
				if(!e.disabled) {
					e.checked = obj.checked;
				}
			} else {
				if(obj != e) {
					e.style.visibility = obj.checked ? 'hidden' : 'visible';
				}
			}
			e.parentNode.parentNode.className = e.checked ? 'item checked' : 'item';
		}
	}
}
function checkclk(obj) {
	var obj = obj.parentNode.parentNode;
	obj.className = obj.className == 'item' ? 'item checked' : 'item';
}
</script>

<?php $this->showtips('技巧提示', ['对于管理员或角色的变更，一般需要对应的管理员重新登录才生效！']); ?>

<?php $form = ActiveForm::begin(['id' => 'role-form']); ?>
	<table class="tb tb2">
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'name'); ?></td></tr>
		<tr class="noborder">
			<?php if ($this->context->action->id == 'role-add'): ?>
			<td class="vtop rowform"><?php echo $form->field($model, 'name')->textInput(); ?></td>
			<td class="vtop tips2">唯一标识，只能是字母、数字或下划线，添加后不能修改</td>
			<?php else: ?>
			<td colspan="2"><?php echo $model->name; ?></td>
			<?php endif; ?>
		</tr>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'title'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform"><?php echo $form->field($model, 'title')->textInput(); ?></td>
			<td class="vtop tips2"></td>
		</tr>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'groups'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform"><?php echo $form->field($model, 'groups')->dropDownList(AdminUserRole::$status, ['prompt' => '选择组名']); ?></td>
			<td class="vtop tips2"></td>
		</tr>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'desc'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform"><?php echo $form->field($model, 'desc')->textarea(); ?></td>
			<td class="vtop tips2"></td>
		</tr>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'permissions'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform" colspan="2">
				<table class="tb tb2">
					<?php foreach ($permissions as $controller => $permission): ?>
						<tr>
							<th class="partition" colspan="15">
								<label><input type="checkbox" onclick="permcheckall(this, '<?php echo $controller; ?>')" class="checkbox"> <?php echo $permission['label']; ?> - <?php echo $controller; ?></label>
							</th>
						</tr>
						<tr>
							<td id="<?php echo $controller; ?>" class="vtop">
								<?php foreach ($permission['actions'] as $action): ?>
								<div class="item<?php echo in_array($action->route, $permissionChecks) ? ' checked' : ''; ?>">
									<label class="txt"><input type="checkbox" onclick="checkclk(this)" class="checkbox" value="<?php echo $action->route; ?>" name="permissions[]"<?php echo in_array($action->route, $permissionChecks) ? ' checked' : ''; ?>><?php echo isset(Yii::$app->params[$controller][$action->title])?$action->title."(".Yii::$app->params[$controller][$action->title].")":$action->title; ?></label>
								</div>
								<?php endforeach; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="15">
				<input type="submit" value="提交" name="submit_btn" class="btn">
			</td>
		</tr>
	</table>
<?php ActiveForm::end(); ?>