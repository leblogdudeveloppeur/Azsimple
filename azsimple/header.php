<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head profile="http://gmpg.org/xfn/11">
		<title><?php bloginfo('name'); ?> <?php if (is_single()) { _e('&raquo; Blog Archive', 'azsimple'); } ?> <?php wp_title(); ?></title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /><!-- leave this for stats please -->
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="alternate" href="<?php bloginfo('rss2_url'); ?>" type="application/rss+xml" title="RSS 2.0" />
		<link rel="alternate" href="<?php bloginfo('rss_url'); ?>" type="text/xml" title="RSS .92" />
		<link rel="alternate" href="<?php bloginfo('atom_url'); ?>" type="application/atom+xml" title="Atom 0.3" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
		<!-- jQuery -->
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascript/jquery-1.7.1.min.js"></script>
	
		<!-- bxSlider for featured posts -->
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascript/jquery.bxSlider.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#featured-posts ul').bxSlider({
					pager: true,
					pagerSelector: '#featured-posts-nav > div',
					controls: false
				});
			});
		</script>
		<?php
			global $options;
			foreach ($options as $value) {
				if (get_settings($value['id']) === false) {
					$$value['id'] = $value['std'];
				} else {
					$$value['id'] = get_settings($value['id']);
				}
			}
		
			wp_get_archives('type=monthly&format=link');
			if (function_exists('wp_enqueue_script') && function_exists('is_singular')) {
				if (is_singular()) wp_enqueue_script('comment-reply');
			}
		?>
	
		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $azs_favicon; ?>" />
	
		<?php wp_head(); ?>
	</head>
	<body>
		<div id="header">
			<div id="header-top">
				<div>
					<?php wp_nav_menu(array('theme_location' => 'menu-1', 'container' => 'div', 'container_class' => 'main-menu')); ?>
					<div id="social">
						<?php
							if ($azs_facebook !== '' && $azs_twitter !== '') {
								printf(__('Follow us: <a href="%1$s">Facebook</a>, <a href="http://twitter.com/%2$s">Twitter</a>, <a href="%3$s">RSS Feed</a>', 'azsimple'), $azs_facebook, $azs_twitter, get_bloginfo('rss2_url'));
							} elseif ($azs_facebook !== '' && $azs_twitter === '') {
								printf(__('Follow us: <a href="%1$s">Facebook</a>, <a href="%2$s">RSS Feed</a>', 'azsimple'), $azs_facebook, get_bloginfo('rss2_url'));
							} elseif ($azs_facebook === '' && $azs_twitter !== '') {
								printf(__('Follow us: <a href="http://twitter.com/%1$s">Twitter</a>, <a href="%2$s">RSS Feed</a>', 'azsimple'), $azs_twitter, get_bloginfo('rss2_url'));
							} elseif ($azs_facebook === '' && $azs_twitter === '') {
								printf(__('Follow us: <a href="%s">RSS Feed</a>', 'azsimple'), get_bloginfo('rss2_url'));
							}
						?>
					</div>
				</div>
			</div>
			<div id="header-bottom">
				<div id="logo">
					<h1><a href="<?php echo get_option('home'); ?>/"><img src="<?php echo $azs_logourl; ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
				</div>
				<div id="header-ads"><?php echo stripslashes($azs_ads468x60); ?></div>
			</div>
		</div>
		<div id="content">