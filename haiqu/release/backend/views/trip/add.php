<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/6 0006
 * Time: 06:41
 */
$this->showsubmenu('行程创建');

?>

<?php echo $this->render('_form', ['model' => $model, 'type' => 'create']); ?>