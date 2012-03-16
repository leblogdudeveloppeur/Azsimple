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
			<input type="text" value="Type search text and press enter..." name="s" id="ls" class="searchfield" onfocus="if (this.value == 'Type search text and press enter...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type search text and press enter...';}" />
		</form>
	</div>

	<div class="sidebar-ads">
		<h2>Advertising</h2>
		<div class="sidebar-ads-wrap"><?php echo stripslashes($azs_ads125x125); ?></div>
	</div>


	<ul class="sidebar-content">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

        <li>
        <h2><?php _e('Categories'); ?></h2>
            <ul>
            <?php wp_list_cats('sort_column=name&hierarchical=0'); ?>
            </ul>
        </li>
      	
        <li>
        <h2><?php _e('Archives'); ?></h2>
            <ul>
            <?php wp_get_archives('type=monthly'); ?>
            </ul>
        </li>
        
        <li>
        <h2><?php _e('Links'); ?></h2>
            <ul>
             <?php get_links(2, '<li>', '</li>', '', TRUE, 'url', FALSE); ?>
             </ul>
        </li>
        
	<?php endif; ?>
	</ul>

</div>
