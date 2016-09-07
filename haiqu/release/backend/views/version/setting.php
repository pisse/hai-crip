<?php

use common\models\KdbInfo;
use backend\components\widgets\ActiveForm;

/**
 * @var backend\components\View $this
 */
$this->showsubmenu('Android版本控制');

?>

<!-- 富文本编辑器 注：360浏览器无法显示编辑器时，尝试切换模式（如兼容模式）-->
<script type="text/javascript">
var UEDITOR_HOME_URL = '<?php echo $this->baseUrl; ?>/js/ueditor/'; //一定要用这句话，否则你需要去ueditor.config.js修改路径的配置信息 
</script>
<script type="text/javascript" src="<?php echo $this->baseUrl; ?>/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl; ?>/js/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
var ue = UE.getEditor('version-new_features');
</script>

<?php $form = ActiveForm::begin(['id' => 'setting-form']); ?>
<table class="tb tb2">
	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'id'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform" disabled="disabled"><?php echo $form->field($version_info, 'id')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>
	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'type'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform" disabled="disabled"><?php echo $form->field($version_info, 'type')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>

	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'has_upgrade'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($version_info, 'has_upgrade')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>

	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'is_force_upgrade'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($version_info, 'is_force_upgrade')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>

	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'new_version'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($version_info, 'new_version')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>
	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'new_ios_version'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($version_info, 'new_ios_version')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>

	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'ard_url'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($version_info, 'ard_url')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>
	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'ard_size'); ?></td></tr>
	<tr class="noborder">
		<td class="vtop rowform"><?php echo $form->field($version_info, 'ard_size')->textInput(); ?></td>
		<td class="vtop tips2"></td>
	</tr>
	<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($version_info, 'new_features'); ?></td></tr>
	<tr class="noborder">
		<td colspan="2">
			<div style="width:780px;height:400px;margin:5px auto 40px 0;">
				<?php echo $form->field($version_info, 'new_features')->textarea(['style' => 'width:780px;height:295px;']); ?>
			</div>
			<div class="help-block"></div>
		</td>
	</tr>

	<tr>
		<td colspan="15">
			<input type="submit" value="提交" name="submit_btn" class="btn">
		</td>
	</tr>
</table>
<?php ActiveForm::end(); ?>