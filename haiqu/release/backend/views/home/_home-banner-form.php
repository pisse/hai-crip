<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 16:06
 */
use backend\components\widgets\ActiveForm;
use common\models\HomeActivity;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
    td.label {
        width: 170px;
        text-align: right;
        font-weight: 700;
    }
    .txt{ width: 100px;}

    .tb2 .txt, .tb2 .txtnobd {
        width: 200px;
        margin-right: 10px;
    }
</style>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseUrl ?>/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseUrl ?>/js/jquery.min.js"></script>
<?php $form = ActiveForm::begin(['id' => 'home-activity-form']); ?>
<table class="tb tb2 fixpadding">
    <tr><th class="partition" colspan="15">添加首页banner信息</th></tr>
    <tr>
        <td class="label">活动类型：</td>
        <td ><?php echo $form->field($home_activity, 'type')->dropDownList(HomeActivity::$type); ?></td>
    </tr>
    <tr>
        <td class="label" id="title">活动标题：</td>
        <td ><?php echo $form->field($home_activity, 'title')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="label" id="subtitle">活动副标题：</td>
        <td ><?php echo $form->field($home_activity, 'subtitle')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="label" id="url">活动连接地址：</td>
        <td ><?php echo $form->field($home_activity, 'url')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="label" id="pic_url">图片连接地址：</td>
        <td ><?php echo $form->field($home_activity, 'pic_url')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="label" id="sign_one">活动标记1：</td>
        <td ><?php echo $form->field($home_activity, 'sign_one')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="label" id="sign_two">活动标记2：</td>
        <td ><?php echo $form->field($home_activity, 'sign_two')->textInput(); ?></td>
    </tr>

    <tr>
        <td></td>
        <td colspan="15">
            <input type="submit" value="提交" name="submit_btn" class="btn">
        </td>
    </tr>
</table>
<?php ActiveForm::end(); ?>