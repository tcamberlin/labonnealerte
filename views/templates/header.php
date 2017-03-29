<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo base_url('/css/style.css') ?>" rel="stylesheet" type="text/css" />
	<!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('/js/lba_charts.js') ?>"></script>-->
	<title><?php echo $title ?> - <?php echo $this->config->item('site_title'); ?></title>
	<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34775355-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>
<body>
	<div id="header">
		<div class="main-wrapper">
			<div class="site-info">
				<h1><?php echo anchor('' , $this->config->item('site_title')); ?></h1>
				<div class="description"><?php echo $this->config->item('site_description'); ?></div>
			</div>
			<ul>
				<li><?php echo anchor('about' , 'à propos'); ?></li>
				<li><?php echo anchor('faq' , 'faq'); ?></li>
				<!--<li><?php echo anchor('statistics/index' , 'statistiques'); ?></li>-->
				<li><?php echo anchor('' , 'accueil'); ?></li>
			</ul>
		</div> <!-- end .main-wrapper -->
	</div>
	<div class="main-wrapper">
		<div id="content">