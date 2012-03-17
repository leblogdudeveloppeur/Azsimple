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


<div id="sidebar">

	<div class="search-form">
		<form action="<?php bloginfo('url'); ?>/" method="get">
			<input type="text" value="<?php _e('Type search text and press enter...', 'azsimple'); ?>" name="s" id="ls" class="searchfield" onfocus="if (this.value == '<?php _e('Type search text and press enter...', 'azsimple'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Type search text and press enter...', 'azsimple'); ?>';}" />
		</form>
	</div>

	<div class="sidebar-ads">
		<h2><?php _e('Advertising', 'azsimple'); ?></h2>
		<div class="sidebar-ads-wrap"><?php echo stripslashes($azs_ads125x125); ?></div>
	</div>


	<ul class="sidebar-content">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

        <li>
        <h2><?php _e('Categories', 'azsimple'); ?></h2>
            <ul>
            <?php wp_list_cats('sort_column=name&hierarchical=0'); ?>
            </ul>
        </li>
      	
        <li>
        <h2><?php _e('Archives', 'azsimple'); ?></h2>
            <ul>
            <?php wp_get_archives('type=monthly'); ?>
            </ul>
        </li>
        
        <li>
        <h2><?php _e('Links', 'azsimple'); ?></h2>
            <ul>
             <?php get_links(2, '<li>', '</li>', '', TRUE, 'url', FALSE); ?>
             </ul>
        </li>
        
	<?php endif; ?>
	</ul>

</div>
