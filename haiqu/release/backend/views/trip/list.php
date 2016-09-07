<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/9/6
 * Time: 02:34
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\widgets\ActiveForm;
use common\models\ProdSpu;
?>
<style>.tb2 th{ font-size: 12px;}</style>
<?php $form = ActiveForm::begin(['method' => "get",'options' => ['style' => 'margin-top: 10px;margin-bottom:10px;'] ]); ?>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseUrl ?>/js/My97DatePicker/WdatePicker.js"></script>
产品编号：<input type="text" value="<?php echo Yii::$app->getRequest()->get('spu_id', ''); ?>" name="spu_id" class="txt" style="width:120px;">&nbsp;
产品标题：<input type="text" value="<?php echo Yii::$app->getRequest()->get('title', ''); ?>" name="title" class="txt" style="width:120px;">&nbsp;
旅游类型：<?php echo Html::dropDownList('spu_type', Yii::$app->getRequest()->get('spu_type', ''), ProdSpu::$spu_type_list,array('prompt' => '-所有类型-')); ?>&nbsp;
旅游性质：<?php echo Html::dropDownList('spu_nature', Yii::$app->getRequest()->get('spu_nature', ''), ProdSpu::$spu_nature_list,array('prompt' => '-所有类型-')); ?>&nbsp;
更新时间：<input type="text" value="<?php echo Yii::$app->getRequest()->get('begintime', ''); ?>" name="begintime" onfocus="WdatePicker({startDate:'%y-%M-%d %H:%m:00',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true,readOnly:true})">
至<input type="text" value="<?php echo Yii::$app->getRequest()->get('endtime', ''); ?>"  name="endtime" onfocus="WdatePicker({startDcreated_atate:'%y-%M-%d %H:%m:00',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true,readOnly:true})">
<input type="submit" name="search_submit" value="过滤" class="btn">
<?php $form = ActiveForm::end(); ?>
<table class="tb tb2 fixpadding">
    <tr class="header">
        <th>产品编号</th>
        <th>产品标题</th>
        <th>促销语</th>
        <th>旅游类型</th>
        <th>旅游性质</th>
        <th>成人价</th>
        <th>儿童价</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($data as $value): ?>
        <tr class="hover">
            <td><?php echo $value['spu_id']; ?></td>
            <td><?php echo $value['title']; ?></td>
            <th><?php echo $value['promotion']; ?></th>
            <th><?php echo isset(ProdSpu::$spu_type_list[$value['spu_type']])?ProdSpu::$spu_type_list[$value['spu_type']]:""; ?></th>
            <th><?php echo isset(ProdSpu::$spu_nature_list[$value['spu_nature']])?ProdSpu::$spu_nature_list[$value['spu_nature']]:""; ?></th>
            <th><?php echo sprintf("%0.2f",$value['price_adult']/100); ?></th>
            <th><?php echo sprintf("%0.2f",$value['price_kid']/100); ?></th>
            <th><?php echo $value['updated_at']; ?></th>
            <td>
             </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php if (empty($data)): ?>
    <div class="no-result">暂无记录</div>
<?php endif; ?>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>
