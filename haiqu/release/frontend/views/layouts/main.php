<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="x-ua-compatible" content="ie=7" />
    <?php echo \yii\helpers\Html::csrfMetaTags(); ?>
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link href="<?php echo $this->baseUrl; ?>/css/theme.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<script type="text/JavaScript">
    var admincpfilename = 'index.php', IMGDIR = 'image/', STYLEID = '1', VERHASH = 'dob', IN_ADMINCP = true, ISFRAME = '0', STATICURL='./', SITEURL = '<?php echo $this->baseUrl; ?>', JSPATH = 'js/';
</script>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>

<script src="<?php echo $this->baseUrl; ?>/js/require.js" type="text/javascript"></script>


<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="container" id="cpcontainer">
    <?php echo $content; ?>
</div>

</body>
</html>