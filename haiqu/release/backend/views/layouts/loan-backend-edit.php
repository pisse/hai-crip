<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 16:06
 */
use common\models\Shop;
use backend\components\widgets\ActiveForm;
use common\models\LoanProject;
use common\models\LoanRecordPeriod;
use yii\helpers\Url;
?>
<div class="itemtitle"><h3>编辑借款信息</h3></div>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseUrl ?>/js/My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
    .tb2 .txt, .tb2 .txtnobd {
        width: 150px;
        margin-right: 10px;
    }
    .td27{ width: 100px;}
    tr{ height: 30px;}
</style>
<?php $form = ActiveForm::begin(['id' => 'loan-form']); ?>
<table style="width: 650px;">
    <tr>
        <td class="td27" colspan="2">借款人ID:</td>
        <td style="width: 300px;">
            <?php if($type == 'add' || $type == 'edit'):?>
                <?php echo $form->field($model, 'loan_person_id')->textInput(); ?>
            <?php else:?>
                <?php echo $person_id;?>
                <input type="hidden" id="loanrecordperiod-loan_person_id" class="txt" value="<?php echo $person_id;?>" name="LoanRecordPeriod[loan_person_id]">
            <?php endif;?>
        </td>
        <td>如果没有则为空或者0</td>
    </tr>
    <tr>
        <td class="td27" colspan="2">用户ID:</td>
        <td style="width: 300px;"><?php echo $form->field($model, 'user_id')->textInput(); ?></td>
        <td>如果没有则为空或者0</td>
    </tr>
    <tr>
        <td class="td27" colspan="2">借款类型:</td>
        <td><?php echo $form->field($model, 'type')->dropDownList(LoanProject::$type_list, ['prompt' => '请选择借款类型']); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">项目信息:</td>
        <td><?php echo $form->field($model, 'loan_project_id')->dropDownList($loan_project_data, ['prompt' => '请选择项目信息']); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">门店信息:</td>
        <td><?php echo $form->field($model, 'shop_id')->dropDownList($shop_data, ['prompt' => '请选择门店信息']); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">还款类型:</td>
        <td><?php echo $form->field($model, 'repay_type')->dropDownList(LoanRecordPeriod::$repay_type, ['prompt' => '请选择还款类型']); ?></td>
    </tr>
    <?php if($type == 'edit'):?>
        <tr>
            <td class="td27" colspan="2">来源:</td>
            <td><?php echo $form->field($model, 'source')->dropDownList(LoanRecordPeriod::$source, ['prompt' => '请选择来源']); ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td class="td27" colspan="2">借款金额:</td>
        <td><?php echo $form->field($model, 'amount')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">放款金额:</td>
        <td><?php echo $form->field($model, 'credit_amount')->textInput(); ?></td>
    </tr>       
    <tr>
        <td class="td27" colspan="2">借款利率:</td>
        <td><?php echo $form->field($model, 'apr')->textInput(); ?></td>
        <td>%</td>
    </tr>
    <tr>
        <td class="td27" colspan="2">服务费率（%）:</td>
        <td><?php echo $form->field($model, 'service_apr')->textInput(); ?></td>
        <td>%</td>
    </tr>
    <tr class="credit">
        <td class="td27" colspan="2">服务费:</td>
        <td><?php echo $form->field($model, 'fee_amount')->textInput(); ?></td>
    </tr>
    <tr class="credit">
        <td class="td27" colspan="2">加急费:</td>
        <td><?php echo $form->field($model, 'urgent_amount')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">借款期限:</td>
        <td><?php echo $form->field($model, 'period')->textInput(); ?></td>
        <td>（N个月）</td>
    </tr>
    <tr>
        <td class="td27" colspan="2">产品类型名称:</td>
        <td><?php echo $form->field($model, 'product_type_name')->textInput(); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">借款日期:</td>
        <td><?php echo $form->field($model, 'apply_time')->textInput(array("onfocus"=>"WdatePicker({startDate:'%y/%M/%d %H:%m:00',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true,readOnly:true});")) ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">状态:</td>
        <td><?php echo $form->field($model, 'status')->dropDownList(LoanRecordPeriod::$status, ['prompt' => '请选择状态']); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2">备注:</td>
        <td><?php echo $form->field($model, 'remark')->textarea(); ?></td>
    </tr>
    <tr>
        <td class="td27" colspan="2"></td>
        <td >
            <input type="submit" value="提交" name="submit_btn" class="btn">
        </td>
    </tr>
</table>
<?php ActiveForm::end(); ?>
<script>



    $("#loanrecordperiod-type").change(function(){
        var type = this.value;
        $.ajax({
            type: 'get',
            url: '<?php echo Url::to(['loan-period/switch-type']); ?>',
            async: false,//同步刷新
            data: {
                key: type
            },
            success: function (data) {
                var json_arr = eval(data);
                $("#loanrecordperiod-loan_project_id option[value != '']").remove();
                if(json_arr.length != 0){
                    for(k in json_arr){
                        $("#loanrecordperiod-loan_project_id").append("<option value="+k+">"+json_arr[k]+"</option>");
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    });

    $("#loanrecordperiod-loan_project_id").change(function(){
        var type = this.value;
        $.ajax({
            type: 'get',
            url: '<?php echo Url::to(['loan-period/switch-shop']); ?>',
            async: false,//同步刷新
            data: {
                key: type
            },
            success: function (data) {
                var json_arr = eval(data);
                $("#loanrecordperiod-shop_id option[value != '']").remove();
                if(json_arr.length != 0){
                    for(k in json_arr){
                        $("#loanrecordperiod-shop_id").append("<option value="+k+">"+json_arr[k]+"</option>");
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    });
</script>
