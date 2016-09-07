<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 15:34
 */
use backend\components\widgets\ActiveForm;
use common\models\HomeActivity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<?php $form = ActiveForm::begin(['id' => 'search_form','method'=>'get', 'action' => ['home/list'], 'options' => ['style' => 'margin-top:5px;']]); ?>
    ID：<input type="text" value="<?php echo Yii::$app->getRequest()->get('id', ''); ?>" name="id" class="txt" style="width:60px;" >&nbsp;
    活动标题：<input type="text" value="<?php echo Yii::$app->getRequest()->get('title', ''); ?>" name="title" class="txt" style="width:120px;">&nbsp;
    状态：<?php echo Html::dropDownList('status', Yii::$app->getRequest()->get('status', ''),HomeActivity::$status)?>&nbsp;
    类型：<?php echo Html::dropDownList('type', Yii::$app->getRequest()->get('type', ''), HomeActivity::$type, array('prompt' => '-所有类型-'))?>&nbsp;
    <input type="submit" name="search_submit" value="过滤" class="btn">
<?php ActiveForm::end(); ?>
    <form name="listform" method="post">
        <table class="tb tb2 fixpadding">
            <tr class="header">
                <th width="2%">ID</th>
                <th width="5%">活动标题</th>
                <th width="5%">活动副标题</th>
                <th width="6%">连接地址</th>
                <th width="8%">图片地址</th>
                <th width="8%">活动标记1</th>
                <th width="8%">活动标记2</th>
                <th width="6%">类型</th>
                <th width="6%">状态</th>
                <th width="4%">操作人</th>
                <th width="20%">更新时间</th>
                <th>操作</th>
            </tr>
            <?php foreach ($home_activity as $value): ?>
                <tr class="hover">
                    <td class="td25"><?php echo $value['id']; ?></td>
                    <td><?php echo $value['title']; ?></td>
                    <td><?php echo $value['subtitle']; ?></td>
                    <td><?php echo $value['url']; ?></td>
                    <td><?php echo $value['pic_url']; ?></td>
                    <td><?php echo $value['sign_one']; ?></td>
                    <td><?php echo $value['sign_two']; ?></td>
                    <td><?php echo HomeActivity::$type[$value['type']]; ?></td>
                    <td><?php echo HomeActivity::$status[$value['status']]; ?></td>
                    <td><?php echo $value['operator_name']; ?></td>
                    <td><?php echo date("Y-m-d H:i:s",$value['updated_at']); ?></td>
                    <td>
                        <?php if ( HomeActivity::STATUS_PENDING == $value['status']): ?>
                            <a onclick="return confirmMsg('确定要置顶吗？');" href="<?php echo Url::to(['home/top', 'id' => $value['id']]); ?>">置顶</a>
                            <a onclick="return confirmMsg('确定要发布吗？');" href="<?php echo Url::to(['home/update', 'id' => $value['id'],'status'=>HomeActivity::STATUS_UP]); ?>">发布</a>
                        <?php endif; ?>
                        <?php if ( HomeActivity::STATUS_UP == $value['status']): ?>
                            <a onclick="return confirmMsg('确定要撤下吗？');" href="<?php echo Url::to(['home/update', 'id' => $value['id'],'status'=>HomeActivity::STATUS_DOWN]); ?>">撤下</a>
                        <?php endif; ?>

                       </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if (empty($home_activity)): ?>
            <div class="no-result">暂无记录</div>
        <?php endif; ?>
    </form>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>