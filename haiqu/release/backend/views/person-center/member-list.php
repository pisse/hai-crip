<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/9/11
 * Time: 15:34
 */
use backend\components\widgets\ActiveForm;
use common\models\UserMember;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<?php $form = ActiveForm::begin(['id' => 'search_form','method'=>'get', 'action' => ['person-center/member-list'], 'options' => ['style' => 'margin-top:5px;']]); ?>
    ID：<input type="text" value="<?php echo Yii::$app->getRequest()->get('id', ''); ?>" name="id" class="txt" style="width:60px;" >&nbsp;
    用户UID：<input type="text" value="<?php echo Yii::$app->getRequest()->get('user_id', ''); ?>" name="user_id" class="txt" style="width:120px;">&nbsp;
    状态：<?php echo Html::dropDownList('status', Yii::$app->getRequest()->get('status', ''),UserMember::$status)?>&nbsp;
    <input type="submit" name="search_submit" value="过滤" class="btn">
<?php ActiveForm::end(); ?>
    <form name="listform" method="post">
        <table class="tb tb2 fixpadding">
            <tr class="header">
                <th width="2%">ID</th>
                <th width="5%">用户UID</th>
                <th width="5%">用户姓名</th>
                <th width="6%">用户手机</th>
                <th width="8%">用户微信号</th>
                <th width="8%">申请日期</th>
                <th width="8%">状态</th>
                <th width="6%">有效期</th>
                <th width="4%">操作人</th>
                <th>操作</th>
            </tr>
            <?php foreach ($user_member as $value): ?>
                <tr class="hover">
                    <td class="td25"><?php echo $value['id']; ?></td>
                    <td><?php echo $value['user_id']; ?></td>
                    <td><?php echo $value['name']; ?></td>
                    <td><?php echo $value['mobile']; ?></td>
                    <td><?php echo $value['weixinno']; ?></td>
                    <td><?php echo $value['apply_time']; ?></td>
                    <td><?php echo $value['status']; ?></td>
                    <td><?php echo $value['effect_time']; ?></td>
                    <td><?php echo $value['operator_name']; ?></td>
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
        <?php if (empty($user_member)): ?>
            <div class="no-result">暂无记录</div>
        <?php endif; ?>
    </form>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>