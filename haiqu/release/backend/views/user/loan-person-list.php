<?php
use yii\helpers\Url;

$this->showsubmenu('用户管理', array(
    array('用户列表', Url::toRoute('user/loan-person-list'), 1)
));
?>

<!--借款项目列表-->
<?php echo $this->render('_loan-person-list', ['loan_person' => $loan_person, 'pages' => $pages]); ?>
