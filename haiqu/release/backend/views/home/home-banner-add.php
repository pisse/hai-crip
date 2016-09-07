<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/8/17
 * Time: 17:51
 */
use backend\components\widgets\ActiveForm;
use common\models\HomeActivity;
use yii\helpers\Url;
?>
<?php echo $this->render('_home-banner-form', ['home_activity' => $home_activity]); ?>
<script>
    $('#uid').parent().css({display : "none"});
    $('#open_id').parent().css({display : "none"});
</script>