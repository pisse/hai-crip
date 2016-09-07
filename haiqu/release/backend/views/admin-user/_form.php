<?php
use backend\components\widgets\ActiveForm;
use backend\models\AdminUserRole;

?>
<style type="text/css">
.item{ float: left; width: 180px; line-height: 25px; margin-left: 5px; border-right: 1px #deeffb dotted; position: relative;}
/*.desc_show{display: none;position: absolute;top:20px;left:25px;background-color: #fff;}*/

</style>
<?php $this->showtips('技巧提示', ['对于管理员或角色的变更，一般需要对应的管理员重新登录才生效！']); ?>

<?php $form = ActiveForm::begin(['id' => 'admin-form']); ?>
	<table class="tb tb2">
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'username'); ?></td></tr>
		<tr class="noborder">
			<?php if ($this->context->action->id == 'add'): ?>
			<td class="vtop rowform"><?php echo $form->field($model, 'username')->textInput(['autocomplete' => 'off']); ?></td>
			<td class="vtop tips2">只能是字母、数字或下划线，不能重复，添加后不能修改</td>
			<?php else: ?>
			<td colspan="2"><?php echo $model->username; ?></td>
			<?php endif; ?>
		</tr>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'phone'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform"><?php echo $form->field($model, 'phone')->textInput(); ?></td>
		</tr>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'role'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform" colspan="2">
				<table class="tb tb2">
					<?php foreach ($roles as $key => $role) {?>
						<?php if($key>0){?>
							<tr>
								<th class="partition" colspan="15">
									<label><?php echo AdminUserRole::$status[$key];?></label>
								</th>
							</tr>
							<tr>
								<td class="vtop">
									<?php foreach ($role as $key => $val): ?>
										<div class="item">
											<label class="txt"><input type="checkbox" class="checkbox" value="<?php echo $key;?>" name="roles[]" <?php if(in_array($key,explode(",", $model->role))){echo "checked";}?>>
												<?php echo $val['title']; ?><br/><span style="color:#999999;"><?php echo $val['desc']; ?></span>
											</label>
											<!-- <div class="desc_show">
												<?php //echo $val['desc']; ?>
											</div> -->
										</div>
										
									<?php endforeach; ?>
								</td>
							</tr>
						<?php }?>
					<?php }?>
					<tr>
						<th class="partition" colspan="15">
							<label><?php echo '未分组';?></label>
						</th>
					</tr>
					<tr>
						<td class="vtop">
							<?php foreach ($roles[0] as $k => $v): ?>
								<?php if($k=='superadmin'){continue;}?>
									<div class="item">
										<label class="txt"><input type="checkbox" class="checkbox" value="<?php echo $k;?>" name="roles[]" <?php if(in_array($k,explode(",", $model->role))){echo "checked";}?>>
											<?php echo $v['title']; ?><br/><?php echo $v['desc']; ?>
										</label>
									</div>
									<!-- <div class="desc_show">
										<?php //echo $v['desc']; ?>
									</div> -->
							<?php endforeach; ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if ($this->context->action->id == 'add'): ?>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'password'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform"><input type="password" autocomplete="off" name="AdminUser[password]" class="txt" id="adminuser-password"></td>
			<td class="vtop tips2">密码为6-16位字符或数字</td>
		</tr>
		<?php endif; ?>
		<tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'mark'); ?></td></tr>
		<tr class="noborder">
			<td class="vtop rowform"><?php echo $form->field($model, 'mark')->textArea(); ?></td>
		</tr>
		<tr>
			<td colspan="15">
				<input type="submit" value="提交" name="submit_btn" class="btn">
			</td>
		</tr>
	</table>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
	// $('.item').bind('mouseover',function(){
	// 	$(this).children('.desc_show').show();
	// });
	// $('.item').bind('mouseout',function(){
	// 	$(this).children('.desc_show').hide();
	// });
</script>