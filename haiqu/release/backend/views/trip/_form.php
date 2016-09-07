<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use common\models\ProdSpu;

?>
<!-- 富文本编辑器 注：360浏览器无法显示编辑器时，尝试切换模式（如兼容模式）-->
<script type="text/javascript" xmlns="http://www.w3.org/1999/html">
    var UEDITOR_HOME_URL = '<?php echo $this->baseUrl; ?>/js/ueditor/'; //一定要用这句话，否则你需要去ueditor.config.js修改路径的配置信息
</script>
<script type="text/javascript" src="<?php echo $this->baseUrl; ?>/js/ueditor/ueditor.config.js?v=2015060801"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl; ?>/js/ueditor/ueditor.all.js?v=2015060801"></script>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseUrl ?>/js/My97DatePicker/WdatePicker.js"></script>

<?php $form = ActiveForm::begin(['id' => 'project-form']); ?>
<table class="tb tb2">

    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'title'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'title')->textInput(); ?></td>
        <td class="vtop tips2">产品标题</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'promotion'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'promotion')->textInput(); ?></td>
        <td class="vtop tips2">促销语</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'intro'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'intro')->textInput(); ?></td>
        <td class="vtop tips2">产品简介</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'spu_type'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'spu_type')->dropDownList(ProdSpu::$spu_type_list, ['prompt' => '请选择旅游类型']); ?></td>
        <td class="vtop tips2">旅游类型</br>(1)旅游类型包含哪些</br>
        </td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'spu_nature'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'spu_nature')->dropDownList(ProdSpu::$spu_nature_list, ['prompt' => '请选择旅游性质']); ?></td>
        <td class="vtop tips2">旅游性质</br>(1)旅游性质包含哪些</br>
        </td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'price_adult'); ?>(元)</td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'price_adult')->textInput(); ?></td>
        <td class="vtop tips2">成人价</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'price_kid'); ?>(元)</td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'price_kid')->textInput(); ?></td>
        <td class="vtop tips2">儿童价</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'place_gather'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'place_gather')->textInput(); ?></td>
        <td class="vtop tips2">集合地</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'place_destination'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'place_destination')->textInput(); ?></td>
        <td class="vtop tips2">目的地</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'intro_destination'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'intro_destination')->textInput(); ?></td>
        <td class="vtop tips2">目的地介绍</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'days_travel'); ?>(天)</td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'days_travel')->textInput(); ?></td>
        <td class="vtop tips2">行程天数</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'pic_num'); ?>(张)</td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'pic_num')->textInput(); ?></td>
        <td class="vtop tips2">图片数量</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'pic_main'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'pic_main')->textInput(); ?></td>
        <td class="vtop tips2">主图url</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'pic_little'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'pic_little')->textInput(); ?></td>
        <td class="vtop tips2">缩略图url</td>
    </tr>
    <tr><td class="td27" colspan="2"><?php echo $this->activeLabel($model, 'supplier'); ?></td></tr>
    <tr class="noborder">
        <td class="vtop rowform"><?php echo $form->field($model, 'supplier')->textInput(); ?></td>
        <td class="vtop tips2">供应商</td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'line_intro'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'line_intro')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('line_intro'); ?></div>
        </td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'activity_intro'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'activity_intro')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('activity_intro'); ?></div>
        </td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'enter_intro'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'enter_intro')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('enter_intro'); ?></div>
        </td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'group_notice'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'group_notice')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('group_notice'); ?></div>
        </td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'fee_intro'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'fee_intro')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('fee_intro'); ?></div>
        </td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'sth_notice'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'sth_notice')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('sth_notice'); ?></div>
        </td>
    </tr>
    <tr>
        <td class="td27" colspan="2">
            <?php echo $this->activeLabel($model, 'enter_notice'); ?>
        </td>
    </tr>
    <tr class="noborder">
        <td colspan="2">
            <div style="width:780px;height:400px;margin:5px auto 40px 0;">
                <?php echo $form->field($model, 'enter_notice')->textarea(['style' => 'width:780px;height:295px;']); ?>
            </div>
            <div class="help-block"><?php echo $model->getFirstError('enter_notice'); ?></div>
        </td>
    </tr>

    <tr>
        <td colspan="15">
            <input type="submit" value="提交" name="submit_btn" class="btn">
        </td>
    </tr>
</table>
<?php ActiveForm::end(); ?>


<script type="text/javascript">
    var ue_linespot = UE.getEditor('prodspu-line_intro');
    var ue_desc = UE.getEditor('prodspu-activity_intro');
    var ue_enter = UE.getEditor('prodspu-enter_intro');

    var ue_notice = UE.getEditor('prodspu-group_notice');
    var ue_fee = UE.getEditor('prodspu-fee_intro');
    var ue_snotice = UE.getEditor('prodspu-sth_notice');

</script>
