<?php require_once 'class/Core.class.php'; ?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<meta name="description" content="Satsang Basic">
	
	<meta name="google-site-verification" content="GMUQWx2t-fqGaiM28fTHky_BN1QD8hPJB51O1ks1z_o" />
	
	<meta name="HandheldFriendly" content="True" />
	<meta name="MobileOptimized" content="320" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" media="(device-height: 568px)" />
	
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="apple-mobile-web-app-title" content="RC Vicharan" />
	
	<link rel="apple-touch-icon-precomposed" sizes="32x32" href="<?php echo IMG_DIR; ?>icon/rc-32.png" />
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo IMG_DIR; ?>icon/rc-57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo IMG_DIR; ?>icon/rc-72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo IMG_DIR; ?>icon/rc-114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo IMG_DIR; ?>icon/rc-144.png" />
	
	<meta name="msapplication-TileImage" content="<?php echo IMG_DIR; ?>icon/rc-114.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	
	<link rel="shortcut icon" href="<?php echo IMG_DIR; ?>icon/rc-32.png" />
	<link rel="icon" href="<?php echo IMG_DIR; ?>icon/rc-32.png" type="image/x-icon" />
		
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-iphone-old.png" media="screen and (max-device-width: 320px) and (max-device-height: 460px)" />
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-iphone-old-retina.png" media="screen and (max-device-width: 320px) and (max-device-height: 480px)" />
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-iphone-retina.png" media="screen and (max-device-width: 320px) and (max-device-height: 568px)" />
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-ipad-landscape.png" media="screen and (min-device-width: 1024px) and (max-device-height: 768px) and (orientation:landscape)" />
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-ipad-portrait.png" media="screen and (min-device-width: 768px) and (max-device-height: 1024px) and (orientation:portrait)" />
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-ipad-landscape-retina.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape) and (-webkit-min-device-pixel-ratio: 2)" />
	<link rel="apple-touch-startup-image" href="<?php echo IMG_DIR; ?>ios-startup/rc-ipad-portrait-retina.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait) and (-webkit-min-device-pixel-ratio: 2)" />
	
	<link rel="stylesheet" href="<?php echo PLUGIN_DIR; ?>font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo PLUGIN_DIR; ?>jquery-flat-calendar.css">
	<link rel="stylesheet" href="<?php echo PLUGIN_DIR; ?>jquery.nanoscroller.css">
<?php 
if(SITE=='local'){
	echo '<link rel="stylesheet" href="'.SRC_DEV_DIR.'main.css">';
}else{
	echo '<link rel="stylesheet" href="'.SRC_DIR.'main.css">';
}
?>
	<script src="<?php echo PLUGIN_DIR; ?>nicEdit.js"></script>
	<script src="<?php echo PLUGIN_DIR; ?>php-md5.min.js"></script>
	<script src="<?php echo PLUGIN_DIR; ?>highcharts.js"></script>
	<script src="<?php echo PLUGIN_DIR; ?>highcharts-exporting.js"></script>

<?php
if(SITE=='local'){
	echo '
	<script src="'.PLUGIN_DEV_DIR.'modernizr-2.8.2.js"></script>
	<script src="'.PLUGIN_DEV_DIR.'jquery-2.1.1.js"></script>
	<script src="'.PLUGIN_DEV_DIR.'jquery-migrate-1.2.1.js"></script>
	<script src="'.SRC_DEV_DIR.'main.js"></script>
	';
}else{
	echo '
	<script src="'.PLUGIN_DIR.'modernizr-2.8.2.min.js"></script>
	<script src="'.PLUGIN_DIR.'jquery-2.1.1.min.js"></script>
	<script src="'.PLUGIN_DIR.'jquery-migrate-1.2.1.min.js"></script>
	<script src="'.SRC_DIR.'main.min.js"></script>
	';
}
?>
	<script src="<?php echo PLUGIN_DIR; ?>jquery.nanoscroller.min.js"></script>
	<script src="<?php echo PLUGIN_DIR; ?>jquery-flat-calendar.js"></script>
	
	<title>RC Vicharan</title>
</head>
<body>
	<section id="na"></section>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62552713-1', 'auto');
  ga('send', 'pageview');
  ga('set', '&uid', OM.session.uid); // Set the user ID using signed-in user_id.

</script>
</body>
</html>