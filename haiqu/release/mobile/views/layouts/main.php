<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"><![endif]-->
<!--[if IE 9]>
<html class="no-js ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="">

    <?php echo \yii\helpers\Html::csrfMetaTags(); ?>
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link href="<?php echo $this->baseUrl; ?>/styles/theme.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
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