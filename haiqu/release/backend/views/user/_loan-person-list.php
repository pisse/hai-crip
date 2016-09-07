<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 15:34
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\widgets\ActiveForm;
use common\models\LoanPerson;
?>
<style>.tb2 th{ font-size: 12px;}</style>
<?php $form = ActiveForm::begin(['method' => "get",'options' => ['style' => 'margin-top: 10px;margin-bottom:10px;'] ]); ?>
    <script language="javascript" type="text/javascript" src="<?php echo $this->baseUrl ?>/js/My97DatePicker/WdatePicker.js"></script>
    ID：<input type="text" value="<?php echo Yii::$app->getRequest()->get('id', ''); ?>" name="id" class="txt" style="width:120px;">&nbsp;
    借款人类型：<?php echo Html::dropDownList('type', Yii::$app->getRequest()->get('type', ''), LoanPerson::$person_type,array('prompt' => '-所有类型-')); ?>&nbsp;
    借款人来源：<?php echo Html::dropDownList('source_id', Yii::$app->getRequest()->get('source_id', ''), LoanPerson::$person_source,array('prompt' => '-所有类型-')); ?>&nbsp;
    借款人名称：<input type="text" value="<?php echo Yii::$app->getRequest()->get('name', ''); ?>" name="name" class="txt" style="width:120px;">&nbsp;
    联系方式：<input type="text" value="<?php echo Yii::$app->getRequest()->get('phone', ''); ?>" name="phone" class="txt" style="width:120px;">&nbsp;
    按时间段：<input type="text" value="<?php echo Yii::$app->getRequest()->get('begintime', ''); ?>" name="begintime" onfocus="WdatePicker({startDate:'%y-%M-%d %H:%m:00',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true,readOnly:true})">
    至<input type="text" value="<?php echo Yii::$app->getRequest()->get('endtime', ''); ?>"  name="endtime" onfocus="WdatePicker({startDcreated_atate:'%y-%M-%d %H:%m:00',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true,readOnly:true})">
    <input type="submit" name="search_submit" value="过滤" class="btn">
<?php $form = ActiveForm::end(); ?>
        <table class="tb tb2 fixpadding">
            <tr class="header">
                <th>ID</th>
                <th>借款人类型</th>
<!--                <th>借款人来源</th>-->
                <th>姓名/公司名称</th>
                <th>联系方式</th>
                <th>生日/成立日期</th>
                <th>性别/行业</th>
                <th>紧急联系人</th>
                <th>紧急联系方式</th>
                <th>来源</th>
                <th>借款人状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php foreach ($loan_person as $value): ?>
                <tr class="hover">
                    <td><?php echo $value['id']; ?></td>
                    <th><?php echo isset(LoanPerson::$person_type[$value['type']])?LoanPerson::$person_type[$value['type']]:"--" ?></th>
<!--                    <th>--><?php //echo LoanPerson::$person_source[$value['source_id']]; ?><!--</th>-->
                    <th><?php echo $value['name']; ?></th>
                    <th><?php echo $value['phone']; ?></th>
                    <th><?php echo date("Y-m-d" , $value['birthday']); ?></th>
                    <th><?php echo $value['property']; ?></th>
                    <th><?php echo $value['contact_username']; ?></th>
                    <th><?php echo $value['contact_phone']; ?></th>
                    <th><?php echo isset(LoanPerson::$person_source[$value['source_id']])?LoanPerson::$person_source[$value['source_id']]:"" ?></th>
                    <th><?php echo isset(LoanPerson::$status[$value['status']])? LoanPerson::$status[$value['status']]:""; ?></th>
                    <th><?php echo date("Y-m-d H:i",$value['created_at']); ?></th>
                    <td>
                        <a href="<?php echo Url::to(['user/loan-person-view', 'id' => $value['id'],'type' => $value['type']]); ?>">查看</a>
                        <a href="<?php echo Url::to(['user/loan-person-edit', 'id' => $value['id']]); ?>">编辑</a>
                       </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if (empty($loan_person)): ?>
            <div class="no-result">暂无记录</div>
        <?php endif; ?>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>