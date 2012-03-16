<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->


        <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- jQuery -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascript/jquery-1.7.1.min.js" ></script>

	<!-- bxSlider for featured posts -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascript/jquery.bxSlider.min.js" ></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#featured-posts-list').bxSlider({
				pager: true,
				pagerSelector: '#featured-posts-pages',
				controls: false
			});
		});
	</script>

	<?php
	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) {
			$$value['id'] = $value['std'];
		}
		else {
			$$value['id'] = get_settings( $value['id'] );
		}
	}
	?>

	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php if (function_exists('wp_enqueue_script') && function_exists('is_singular')) : ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php endif; ?>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $azs_favicon; ?>" />

	<?php wp_head(); ?>

</head>

<body>
	<div id="header">
		<div class="header-top">
			<div class="main-menu-container">
				<?php wp_nav_menu(array('theme_location' => 'menu-1', 'container' => 'div', 'container_class' => 'main-menu')); ?>
				<div class="social">
					Follow us: <a href="<?php echo $azs_facebook; ?>">Facebook</a>, <a href="http://twitter.com/<?php echo $azs_twitter; ?>">Twitter</a>, <a href="<?php bloginfo('rss2_url'); ?>">RSS Feed</a>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="logo" style="background-image: url(<?php echo $azs_logourl; ?>);">
				<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			</div>
			<div class="header-advertising"><?php echo stripslashes($azs_ads468x60); ?></div>
		</div>
	</div>



