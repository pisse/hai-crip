<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 15:53
 */
use common\models\loanPerson;
use yii\helpers\Url;
use common\models\CreditZmop;

?>
<table class="tb tb2 fixpadding">
    <tr><th class="partition" colspan="15">借款人信息</th></tr>
    <?php if(isset($loan_person) && !empty($loan_person)): ?>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'id'); ?></td>
            <td width="300"><?php echo $loan_person['id']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $tittle['id_number']; ?></td>
            <td ><?php echo $loan_person['id_number']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'type'); ?></td>
            <td ><?php echo isset(LoanPerson::$person_type[$loan_person['type']])?LoanPerson::$person_type[$loan_person['type']]:""; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $tittle['name']; ?></td>
            <td><?php echo $loan_person['name']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'phone'); ?></td>
            <td colspan="3"><?php echo $loan_person['phone']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $tittle['birthday']; ?></td>
            <td colspan="3"><?php echo date('Y-m-d',$loan_person['birthday']); ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $tittle['property']; ?></td>
            <td colspan="3"><?php echo $loan_person['property']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $tittle['contact_username']; ?></td>
            <td colspan="3"><?php echo $loan_person['contact_username']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $tittle['contact_phone']; ?></td>
            <td colspan="3"><?php echo $loan_person['contact_phone']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'attachment'); ?></td>
            <?php if(empty($loan_person['attachment'])) :?>
            <td colspan="3">--待上传--</td>
            <?php else: ?>
            <td colspan="3"><a href="<?php echo Url::to(['loan/loan-person-pic', 'id' => $loan_person['id']])?>">查看</a></td>
            <?php endif;?>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'credit_limit'); ?></td>
            <td colspan="3"><?php echo $loan_person['credit_limit']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'open_id'); ?></td>
            <td colspan="3"><?php echo $loan_person['open_id']; ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'created_at'); ?></td>
            <td colspan="3"><?php echo date('Y-m-d H:i:s',$loan_person['created_at']); ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($loan_person, 'updated_at'); ?></td>
            <td colspan="3"><?php echo date('Y-m-d H:i:s',$loan_person['updated_at']); ?></td>
        </tr>


        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'real_pay_pwd_status'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['real_pay_pwd_status'])?"否":"是" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'real_verify_status'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['real_verify_status'])?"否":"是" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'real_work_status'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['real_work_status'])?"否":"是" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'real_contact_status'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['real_contact_status'])?"否":"是" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'real_bind_bank_card_status'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['real_bind_bank_card_status'])?"否":"是" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'real_zmxy_status'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['real_zmxy_status'])?"否":"是" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'is_quota_novice'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['is_quota_novice'])?"是":"否" ?></td>
        </tr>
        <tr>
            <td class="td24"><?php echo $this->activeLabel($user_verification, 'is_fzd_novice'); ?></td>
            <td colspan="3"><?php echo empty($user_verification['is_fzd_novice'])?"是":"否" ?></td>
        </tr>


    <?php else: ?>
        <tr>
            <td>暂无借款人相关信息</td>
        </tr>
    <?php endif; ?>
</table>

<table class="tb tb2 fixpadding" id="creditreport">
    <tr><th class="partition" colspan="10">用户不良信息查询</th></tr>
    <tr>
        <td width="200">黑灰名单查询</td>
        <td><a href="<?php echo Url::toRoute(['loan-person-bad-info/view','id'=>$loan_person['id']]);?>">点击查看</a></td>
    </tr>
</table>
<table class="tb tb2 fixpadding" id="creditreport">
    <tr><th class="partition" colspan="10">征信信息</th></tr>
    <tr>
        <td width="200">芝麻信用报告</td>
        <td><a href="<?php echo Url::toRoute(['zmop/user-zmop-view','id'=>$loan_person['id']]);?>">点击查看</a></td>
    </tr>
    <tr>
        <td width="200">蜜罐报告</td>
        <td><a href="<?php echo Url::toRoute(['jxl/user-view','id'=>$loan_person['id']]);?>">点击查看</a></td>
    </tr>
    <tr>
        <td width="200">防控宝宝高</td>
        <td><a href="<?php echo Url::toRoute(['fkb/user-view','id'=>$loan_person['id']]);?>">点击查看</a></td>
    </tr>
</table>



