<h3>提示</h3>

<div class="infobox">
	<h4 class="<?php echo $messageClassName; ?>"><?php echo $message; ?></h4>
	<p class="marginbot">
		<?php if (empty($url)): ?>
		<script type="text/javascript">
		if(history.length > 0) document.write('<a href="javascript:history.go(-1);" class="lightlink">点击这里返回上一页</a>');
		</script>
		<?php else: ?>
		<p class="marginbot">
			<a href="<?php echo $url; ?>" class="lightlink">如果您的浏览器没有自动跳转，请点击这里</a>
		</p>
		<script type="text/JavaScript">setTimeout("redirect('<?php echo $url; ?>');", 3000);</script>
		<?php endif; ?>
	</p>
</div>
