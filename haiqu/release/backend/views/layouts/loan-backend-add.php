<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 16:06
 */
?>
<div class="itemtitle"><h3>添加借款信息</h3></div>
<?php
 echo $this->render('_loan-backend-form', [
        'model' => $loan_record,
        'shop' => $shop,
        'loan_project' => $loan_project,
        'type' => $type,
        'person_id' => $loan_person_id,
        'user_id' => $user_id,
    ]);
?>


