<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head id="www-sitename-com" data-template-set="html5-reset-wordpress-theme" profile="http://gmpg.org/xfn/11">

	<meta charset="<?php bloginfo('charset'); ?>">
	

    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php if (is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<meta name="title" content="<?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	
	<meta name="google-site-verification" content="">
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
	
	<meta name="author" content="Your Name Here">
	<meta name="Copyright" content="Copyright Your Name Here 2011. All Rights Reserved.">

	<!-- Dublin Core Metadata : http://dublincore.org/ -->
	<meta name="DC.title" content="Project Name">
	<meta name="DC.subject" content="What you're about.">
	<meta name="DC.creator" content="Who made this site.">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon-144x144.png" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<!-- all our JS is at the bottom of the page, except for Modernizr. -->
	<script src="<?php bloginfo('template_directory'); ?>/_/js/modernizr-1.7.min.js"></script>
	<script type="text/javascript" src="//use.typekit.net/kpq6drv.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble-compiled.js"></script>
    <script type="text/javascript" src="https://raw.github.com/okouam/jquery-bbq/master/jquery.ba-bbq.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/_/js/jquery.simplePagination.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/_/js/jquery.customSelect.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/_/js/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/_/js/functions.js"></script>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	
</head>

<body class="noise">
	
	

		<header id="header" role="banner" class="noise">
			<section class="wrap top">
				<div class="grid-5">
				<h1 class="logo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_directory'); ?>/_/img/logo.png" /></a></h1>
				</div>
				
				<div class="grid-4">
				<ul class="contact-head">
					<li><i class="sprite tel">Telephone:</i>020 7078 1110</li>
					<li><i class="sprite add">Address:</i>1 Lanark Place, Little Venice, W9 1BT</li>
					<li><i class="sprite eml">Email:</i><a href="mailto: info@diamondresidential.co.uk" title="Click here to email Diamond Residential">info@diamondresidential.co.uk</a></li>
				</ul>
				</div>
				
				<div class="grid-3 last">
					<a class="sml-btn btn pink-btn" href="<?= get_option('home'); ?>/register-with-us/" title="Click here to register with Diamond Residential">Register with us</a> <a class="sml-btn btn pink-btn" href="<?= get_option('home'); ?>/free-property-valuation/" title="Click here for a free Property Valuation">Free Property Valuation</a>
				</div>
				
			</section>

		</header>
		
		<nav role="navigation" class="primary-nav">
		<section class="wrap">
				<div class="grid-12">
				<nav class="nav"><?php wp_nav_menu(); ?></nav>
			</div>
		</section>
		</nav>
		
		<section class="wrap prop-finder noise">
			<?php include (TEMPLATEPATH . '/property-search.php' ); ?>
		</section>

