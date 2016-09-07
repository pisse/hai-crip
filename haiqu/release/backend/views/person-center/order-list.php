<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/8/11
 * Time: 15:34
 */
use backend\components\widgets\ActiveForm;
use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<?php $form = ActiveForm::begin(['id' => 'search_form','method'=>'get', 'action' => ['person-center/order-list'], 'options' => ['style' => 'margin-top:5px;']]); ?>
    订单编号：<input type="text" value="<?php echo Yii::$app->getRequest()->get('id', ''); ?>" name="id" class="txt" style="width:60px;" >&nbsp;
    联系人：<input type="text" value="<?php echo Yii::$app->getRequest()->get('contact', ''); ?>" name="contact" class="txt" style="width:120px;">&nbsp;
    订单状态：<?php echo Html::dropDownList('status', Yii::$app->getRequest()->get('status', ''),Order::$status)?>&nbsp;
    手机号：<input type="text" value="<?php echo Yii::$app->getRequest()->get('mobile', ''); ?>" name="mobile" class="txt" style="width:60px;" >&nbsp;
    <input type="submit" name="search_submit" value="过滤" class="btn">
<?php ActiveForm::end(); ?>
    <form name="listform" method="post">
        <table class="tb tb2 fixpadding">
            <tr class="header">
                <th width="7%">订单编号</th>
                <th width="5%">线路编号</th>
                <th width="20%">线路名称</th>
                <th width="6%">出发日期</th>
                <th width="8%">线路类型</th>
                <th width="8%">订单状态</th>
                <th width="8%">总金额</th>
                <th width="6%">支付金额</th>
                <th width="6%">备注</th>
                <th width="6%">创建时间</th>
                <th>操作</th>
            </tr>
            <?php foreach ($order_list as $value): ?>
                <tr class="hover">
                    <td class="td25"><?php echo $value['']; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo Order::$status[$value['status']]; ?></td>
                    <td><?php echo $value['']; ?></td>
                    <td><?php echo date("Y-m-d H:i:s",$value['']); ?></td>
                    <td>


                       </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if (empty($order_list)): ?>
            <div class="no-result">暂无记录</div>
        <?php endif; ?>
    </form>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>