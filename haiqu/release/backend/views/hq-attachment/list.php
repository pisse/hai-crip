<?php

use yii\helpers\Url;
use yii\helpers\FileHelper;

/**
 * @var backend\components\View $this
 */
$this->shownav('content', 'menu_attachment_add');
$this->showsubmenu('附件管理', array(
	array('列表', Url::toRoute('hq-attachment/list'), 1),
	array('添加附件', Url::toRoute('hq-attachment/add'), 0),
));

?>

<table class="tb tb2 fixpadding">
	<tr class="header">
		<th>文件名</th>
		<th>预览</th>
		<th>大小</th>
		<th>地址</th>
		<th>创建时间</th>
		<th>操作</th>
	</tr>
	<?php foreach ($prefixes as $v): ?>
	<tr>
		<td><a href="<?php echo Url::to(['hq-attachment/list', 'prefix' => strval($v['prefix'])]); ?>"><?php echo basename($v['prefix']).'/'; ?></a></td>
		<td>文件夹</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
	</tr>
	<?php endforeach; ?>
	<?php foreach ($contents as $content): ?>
	<tr>
		<td><?php echo basename($content['file_name']); ?></td>
		<td><?php echo in_array(FileHelper::getMimeTypeByExtension(basename($content['file_name'])), ['image/jpeg','image/png','image/gif'])
		? '<a target="_blank" href="'.$content['show'].'"><img src="'.$content['show'].'" width="50" height="50"/></a>'
		: '-'; ?></td>
		<td><?php echo $content['size']; ?></td>
		<td><?php echo $content['address'] ?></td>
		<td><?php echo $content['created_at']; ?></td>
		<td><a onclick="return confirmMsg('确定要删除吗？不可恢复哦！');" href="<?php echo Url::to(['hq-attachment/delete', 'key' => strval($content['address'])]); ?>">删除</a></td>
	</tr>
	<?php endforeach; ?>
</table>